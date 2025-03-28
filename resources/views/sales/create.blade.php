<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create Sale
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Mostrar errores de validación -->
                @if ($errors->any())
                    <div class="mb-4">
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

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

                        <!-- Campos de fechas -->
                        <x-forms.input label="Start Date" name="start_date" type="date" required id="start_date" />
                        <x-forms.input label="Agreed Date" name="agreed_date" type="date" required id="agreed_date" />

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

        function toggleMedicationFields(enable) {
            document.querySelectorAll('.medication-select, .quantity-input, .remove-medication-btn').forEach(el => {
                el.disabled = !enable;
            });
            addMedicationBtn.disabled = !enable;
            addMedicationBtn.classList.toggle('disabled:opacity-50', !enable);
        }

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
            updateMedicationSelectOptions();
        }

        function updateSubTotal(inputElement) {
            const row = inputElement.closest('.medication-row');
            const quantity = row.querySelector('.quantity-input').value;
            const medicationId = row.querySelector('.medication-select').value;
            const subTotalInput = row.querySelector('.subtotal-input');

            const price = prices[medicationId];
            if (price && quantity) {
                subTotalInput.value = (price * quantity).toFixed(2);
            } else {
                subTotalInput.value = '';
            }
            updateTotal();
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal-input').forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            totalAmountElement.value = total.toFixed(2);
        }

        function updateMedicationSelectOptions() {
            const selects = document.querySelectorAll('.medication-select');
            const selectedValues = Array.from(selects).map(select => select.value).filter(val => val !== '');
            selects.forEach(select => {
                Array.from(select.options).forEach(option => {
                    if (option.value !== '' && selectedValues.includes(option.value) && select.value !== option.value) {
                        option.disabled = true;
                    } else {
                        option.disabled = false;
                    }
                });
            });
        }

        addMedicationBtn.addEventListener('click', function() {
            if (clientSelect.value === '') return;

            const newRowIndex = medicationsSection.children.length;
            const newRow = document.createElement('div');
            newRow.classList.add('medication-row');

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

            const template = document.createElement('template');
            template.innerHTML = newRow.innerHTML.trim();
            const realElements = template.content.firstChild;
            newRow.innerHTML = '';
            newRow.appendChild(realElements);

            newRow.querySelector('.quantity-input').addEventListener('input', function() {
                updateSubTotal(this);
            });
            newRow.querySelector('.medication-select').addEventListener('change', function() {
                updateSubTotal(this);
                updateMedicationSelectOptions();
            });

            updateMedicationSelectOptions();
        });

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
                updateMedicationSelectOptions();
            }
        });

        document.querySelector('.quantity-input')?.addEventListener('input', function() {
            updateSubTotal(this);
        });
        document.querySelector('.medication-select')?.addEventListener('change', function() {
            updateSubTotal(this);
            updateMedicationSelectOptions();
        });

        toggleMedicationFields(false);

        // validation of dates
        const startDateInput = document.getElementById('start_date');
        const agreedDateInput = document.getElementById('agreed_date');

        startDateInput.addEventListener('change', function() {
            agreedDateInput.min = this.value;
            if (agreedDateInput.value && agreedDateInput.value < this.value) {
                agreedDateInput.value = this.value;
            }
        });
    </script>
</x-app-layout>
