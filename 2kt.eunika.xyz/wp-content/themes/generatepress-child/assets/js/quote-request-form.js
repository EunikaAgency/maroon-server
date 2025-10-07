
            // Quantity Selector Functionality
            document.addEventListener('DOMContentLoaded', function() {
                const quantityInput = document.querySelector('.qty-input');
                const minusBtn = document.querySelector('.qty-btn.minus');
                const plusBtn = document.querySelector('.qty-btn.plus');
                const quantityContainer = document.getElementById('quantity-container');

                // Initialize the state
                function checkQuantityState() {
                    if (quantityInput.value !== "") {
                        quantityContainer.classList.add('quantity-filled');
                    }
                }

                // Check on page load
                checkQuantityState();

                minusBtn.addEventListener('click', () => {
                    let currentValue = parseInt(quantityInput.value) || 0;
                    if (currentValue > 0) {
                        quantityInput.value = currentValue - 1;
                    }
                    quantityContainer.classList.add('quantity-filled');
                });

                plusBtn.addEventListener('click', () => {
                    let currentValue = parseInt(quantityInput.value) || 0;
                    quantityInput.value = currentValue + 1;
                    quantityContainer.classList.add('quantity-filled');
                });

                quantityInput.addEventListener('focus', () => {
                    quantityContainer.classList.add('quantity-focused');
                });

                quantityInput.addEventListener('blur', () => {
                    quantityContainer.classList.remove('quantity-focused');
                });

                quantityInput.addEventListener('input', () => {
                    if (quantityInput.value < 0) {
                        quantityInput.value = 0;
                    }
                    if (quantityInput.value !== "") {
                        quantityContainer.classList.add('quantity-filled');
                    }
                });

                // Floating label functionality for other fields
                document.querySelectorAll('.quote-form .form-group:not(.checkbox-group) input, .quote-form .form-group textarea, .quote-form .form-group select').forEach(input => {
                    const formGroup = input.closest('.form-group');
                    if (input.value) {
                        formGroup.classList.add('filled');
                    }
                    input.addEventListener('focus', () => formGroup.classList.add('focused'));
                    input.addEventListener('blur', () => {
                        formGroup.classList.remove('focused');
                        input.value ? formGroup.classList.add('filled') : formGroup.classList.remove('filled');
                    });
                    input.addEventListener('input', () => {
                        input.value ? formGroup.classList.add('filled') : formGroup.classList.remove('filled');
                    });
                });
            });