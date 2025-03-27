<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create Sale
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <x-forms.form method="POST" action="/sales">
                    <div class="space-y-6">

                        <x-forms.select label="Client" name="client_id" :options="$clients" required id="client-select" />

                        <div id="medications-section">
                            <div class="medication-row">
                                <div class="flex space-x-4">
                                    <x-forms.select
                                        label="Medication"
                                        name="medications[0][id]"
                                        :options="$medications"
                                        required
                                        class="medication-select"
                                        disabled
                                    />
                                    <x-forms.input
                                        label="Quantity"
                                        name="medications[0][quantity]"
                                        type="number"
                                        min="1"
                                        required
                                        class="quantity-input"
                                        disabled
                                    />
                                    <x-forms.input
                                        label="Sub Total"
                                        name="medications[0][sub_total]"
                                        type="number"
                                        class="subtotal-input"
                                        readonly
                                        disabled
                                    />
                                    <x-danger-button
                                        type="button"
                                        class="remove-medication-btn mt-8"
                                        disabled
                                    >
                                        Remove
                                    </x-danger-button>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button
                                type="button"
                                id="add-medication-btn"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md disabled:opacity-50"
                                disabled
                            >
                                Add Medication
                            </button>
                        </div>

                        <x-forms.input
                            id="total-amount"
                            label="Total"
                            name="total"
                            type="number"
                            readonly
                        />

                        <x-forms.divider/>
                        <x-forms.input label="Start Date" name="start_date" type="date" required />
                        <x-forms.input label="Agreed Date" name="agreed_date" type="date" required />

                        <div class="text-center py-4">
                            <x-forms.button type="submit">Create Sale</x-forms.button>
                        </div>
                    </div>
                </x-forms.form>

                <div class="ml-4 mb-4">
                    <x-action-button href="/sales">Sale's List</x-action-button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const prices = @json($prices);
        const medicationsSection = document.getElementById('medications-section');
        const addMedicationBtn = document.getElementById('add-medication-btn');
        const totalAmountElement = document.getElementById('total-amount');
        const clientSelect = document.getElementById('client-select');
        const allMedications = @json($medications);

        // Función para habilitar/deshabilitar campos
        function toggleMedicationFields(enable) {
            document.querySelectorAll('.medication-select, .quantity-input, .remove-medication-btn').forEach(el => {
                el.disabled = !enable;
            });
            addMedicationBtn.disabled = !enable;
            addMedicationBtn.classList.toggle('disabled:opacity-50', !enable);
        }

        // Función para resetear medicamentos
        function resetMedications() {
            const rows = medicationsSection.querySelectorAll('.medication-row');
            for (let i = 1; i < rows.length; i++) {
                rows[i].remove();
            }

            const firstRow = rows[0];
            firstRow.querySelector('.medication-select').value = '';
            firstRow.querySelector('.quantity-input').value = '';
            firstRow.querySelector('.subtotal-input').value = '';
            updateTotal();
        }

        // Función para actualizar subtotal
        function updateSubTotal(inputElement) {
            const row = inputElement.closest('.medication-row');
            const quantity = row.querySelector('.quantity-input').value;
            const medicationId = row.querySelector('.medication-select').value;
            const subTotalInput = row.querySelector('.subtotal-input');

            const price = prices[medicationId];
            if (price && quantity) {
                subTotalInput.value = (price * quantity).toFixed(2);
                updateTotal();
            } else {
                subTotalInput.value = '';
                updateTotal();
            }
        }

        // Función para calcular total
        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal-input').forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            totalAmountElement.value = total.toFixed(2);
        }

        // Evento para agregar nueva fila (usando x-forms)
        addMedicationBtn.addEventListener('click', function() {
            if (clientSelect.value === '') return;

            const newRowIndex = medicationsSection.children.length;
            const newRow = document.createElement('div');
            newRow.classList.add('medication-row');

            // Crear elementos usando el mismo formato que x-forms
            newRow.innerHTML = `
                <div class="flex space-x-4">
                    <x-forms.select
                        label="Medication"
                        name="medications[${newRowIndex}][id]"
                        :options="$medications"
                        required
                        class="medication-select"
                    />
                    <x-forms.input
                        label="Quantity"
                        name="medications[${newRowIndex}][quantity]"
                        type="number"
                        min="1"
                        required
                        class="quantity-input"
                    />
                    <x-forms.input
                        label="Sub Total"
                        name="medications[${newRowIndex}][sub_total]"
                        type="number"
                        class="subtotal-input"
                        readonly
                    />
                    <x-danger-button
                        type="button"
                        class="remove-medication-btn mt-8"
                    >
                        Remove
                    </x-danger-button>
                </div>
            `;

            medicationsSection.appendChild(newRow);

            // Convertir el HTML string a elementos DOM reales
            const template = document.createElement('template');
            template.innerHTML = newRow.innerHTML.trim();
            const realElements = template.content.firstChild;

            // Reemplazar el placeholder con los elementos reales
            newRow.innerHTML = '';
            newRow.appendChild(realElements);

            // Agregar eventos
            newRow.querySelector('.quantity-input').addEventListener('input', function() {
                updateSubTotal(this);
            });

            newRow.querySelector('.medication-select').addEventListener('change', function() {
                updateSubTotal(this);
            });
        });

        // Resto de eventos (se mantienen igual)
        clientSelect.addEventListener('change', function() {
            const clientSelected = this.value !== '';
            toggleMedicationFields(clientSelected);
            if (!clientSelected) resetMedications();
        });

        medicationsSection.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-medication-btn') &&
                medicationsSection.querySelectorAll('.medication-row').length > 1) {
                event.target.closest('.medication-row').remove();
                updateTotal();
            }
        });

        // Inicialización
        document.querySelector('.quantity-input')?.addEventListener('input', function() {
            updateSubTotal(this);
        });

        document.querySelector('.medication-select')?.addEventListener('change', function() {
            updateSubTotal(this);
        });

        toggleMedicationFields(false);
    </script>
</x-app-layout>
