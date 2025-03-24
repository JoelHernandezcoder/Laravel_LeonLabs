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

                        <x-forms.select label="Client" name="client_id" :options="$clients" required />

                        <div id="medications-section">
                            <div class="medication-row">
                                <div class="flex space-x-4">
                                    <x-forms.select
                                        label="Medication"
                                        name="medications[0][id]"
                                        :options="$medications"
                                        required
                                    />
                                    <x-forms.input
                                        label="Units"
                                        name="medications[0][units]"
                                        type="number"
                                        min="1"
                                        required
                                    />
                                    <x-forms.input
                                        label="Sub Total"
                                        name="medications[0][sub_total]"
                                        type="number"
                                        readonly
                                    />
                                    <x-danger-button class="remove-medication-btn mt-8">Remove</x-danger-button>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="button" id="add-medication-btn" class="px-4 py-2 bg-blue-500 text-white rounded-md">
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

                        <x-forms.input label="Agreed Date" name="agreed_date" type="date" required />

                        <div class="text-center py-4">
                            <x-forms.button>Create Sale</x-forms.button>
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
        const totalAmountElement = document.getElementById('total-amount'); // El elemento donde mostramos el total

        // Función para actualizar el subtotal cuando cambian las unidades
        function updateSubTotal(inputElement) {
            const row = inputElement.closest('.medication-row');
            const units = row.querySelector('input[name*="units"]').value;
            const medicationId = row.querySelector('select[name*="id"]').value;
            const subTotalInput = row.querySelector('input[name*="sub_total"]');

            const price = prices[medicationId];
            if (price && units) {
                subTotalInput.value = (price * units).toFixed(2);
                updateTotal(); // Actualizamos el total cada vez que se cambie un subtotal
            }
        }

        // Función para calcular el total de la venta
        function updateTotal() {
            let total = 0;
            const subTotalInputs = document.querySelectorAll('input[name*="sub_total"]');
            subTotalInputs.forEach(subTotalInput => {
                total += parseFloat(subTotalInput.value) || 0;
            });
            totalAmountElement.value = total.toFixed(2); // Mostrar el total actualizado en el campo de entrada
        }

        // Agregar nueva fila de medicamento
        addMedicationBtn.addEventListener('click', function () {
            const newRowIndex = medicationsSection.children.length;
            const newRow = document.createElement('div');
            newRow.classList.add('medication-row');
            newRow.innerHTML = `
                <div class="flex space-x-4">
                    <x-forms.select label="Medication" name="medications[${newRowIndex}][id]" :options="$medications" required />
                    <x-forms.input label="Units" name="medications[${newRowIndex}][units]" type="number" min="1" required />
                    <x-forms.input label="Sub Total" name="medications[${newRowIndex}][sub_total]" type="number" readonly />
                    <x-danger-button class="remove-medication-btn mt-8">Remove</x-danger-button>
                </div>
            `;
            medicationsSection.appendChild(newRow);

            const unitInput = newRow.querySelector('input[name*="units"]');
            const medicationSelect = newRow.querySelector('select[name*="id"]');

            unitInput.addEventListener('input', function () {
                updateSubTotal(unitInput);
            });

            medicationSelect.addEventListener('change', function () {
                updateSubTotal(medicationSelect);
            });
        });

        // Eliminar medicamento
        medicationsSection.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-medication-btn')) {
                event.target.closest('.medication-row').remove();
                updateTotal(); // Actualizar el total después de eliminar una fila
            }
        });

        // Actualizar subtotales en todas las filas al cambiar unidades
        const allUnitInputs = document.querySelectorAll('input[name*="units"]');
        allUnitInputs.forEach(input => input.addEventListener('input', function () {
            updateSubTotal(input);
        }));

        // Inicializar el total al cargar la página
        updateTotal();
    </script>
</x-app-layout>
