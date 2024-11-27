<!-- @if ($errors->any())
<div class="alert alert-danger col-lg-6 mx-auto">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if (session('success'))
<div class="alert alert-success col-lg-6 mx-auto">
    {{ session('success') }}
</div>
@endif -->
<style>
    /* Custom Styles */
    .form-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .form-title {
        font-size: 24px;
        margin-bottom: 20px;
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .option-input {
        flex: 1;
        margin-right: 10px;
    }

    .btn-add-option {
        margin-left: 10px;
    }

    .linear-scale-fields {
        display: none;
    }


    .row,
    .column {
        display: none;
    }
</style>
<div class="container">
    <div class="form-container">
        <h2 class="form-title">Form Builder</h2>


        <form id="myForm" action="{{ route('form_builder.store') }}" method="post">
            @csrf
            <div class="from-group">
                <label for="label" class="form-label">Form Title</label>
                <input type="text" class="form-control mb-3" id="form_title" name="form_title" value="{{ $form_title }}">
            </div>

            <div class="form-group">
                <label for="label" class="form-label">Form Description</label>
                <textarea class="form-control" id="form_desc" name="form_desc">{{ $form_desc }}</textarea>
            </div>

            <div class="form-group">
                <label for="label" class="form-label">Field Label</label>
                <input type="text" class="form-control" id="label" name="label">
            </div>
            <div class="form-group">
                <label for="type" class="form-label">Field Type</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="text">Short Text</option>
                    <option value="textarea">Long Text</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="multiple_choice">Multiple choice</option>
                    <option value="image">Image</option>
                    <option value="select">Drop-down</option>
                    <option value="date">Date</option>
                    <option value="time">Time</option>
                    <option value="signature">Signature</option>
                    <option value="file">File Upload</option>
                    <option value="grid">Grid</option>
                    <option value="mgrid">Multiple Choice grid</option>
                    <option value="linear_scale">Linear Scale</option>
                    <option value="email">Email</option>
                    <option value="video">Video</option>
                    <!-- Add more field types as needed -->
                </select>
            </div>
            <div class="mb-3 form-check">
                <!-- Hidden input field to ensure 'required' field is always submitted -->
                <!-- <input type="hidden" name="required" value="0"> -->
                <!-- Checkbox input field -->
                <input type="checkbox" class="form-check-input" id="requiredCheckbox" name="required">
                <label class="form-check-label" for="requiredCheckbox">Required</label>
            </div>
            <div id="grid-options">
                <div id="row-inputs-container" class="mb-3">
                    <label for="row_name" class="form-label">Row Name</label>
                    <!-- <input type="text" class="form-control" id="row_name" name="row_name[]"> -->
                </div>
                <button type="button" class="btn btn-secondary mb-3" style="background-color: #d32f2f;" id="add-row-btn">Add Row</button>

                <div id="column-inputs-container" class="mb-3">
                    <label for="column_name" class="form-label">Column Name</label>
                    <!-- <input type="text" class="form-control" id="column_name" name="column_name[]"> -->
                </div>
                <button type="button" class="btn btn-secondary mb-3" style="background-color: #d32f2f;" id="add-column-btn">Add Column</button>
            </div>
            <div class="mb-3 linear-scale-field">
                <label for="min_value" class="form-label">Minimum Value</label>
                <input type="number" class="form-control" id="min_value" name="min_value">
            </div>
            <div class="mb-3 linear-scale-field">
                <label for="max_value" class="form-label">Maximum Value</label>
                <input type="number" class="form-control" id="max_value" name="max_value">
            </div>
            <div class="mb-3 linear-scale-field">
                <label for="step" class="form-label">Step</label>
                <input type="number" class="form-control" id="step" name="step">
            </div>
            <div class="mb-3 linear-scale-field">
                <label for="left_label" class="form-label">Left Label</label>
                <input type="text" placeholder="optional" class="form-control" id="left_label" name="left_label">
            </div>
            <div class="mb-3 linear-scale-field">
                <label for="right_label" class="form-label">Right Label</label>
                <input type="text" placeholder="optional" class="form-control" id="right_label" name="right_label">
            </div>


            <div id="options-container">
                <!-- Options will be dynamically added here -->
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-secondary mb-3 rounded-circle" id="add-option-btn" style="display: none; background-color: #d32f2f; border: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); color: #fff; font-size: 12px; padding: 10px 15px; transition: all 0.3s ease;">
                    <span style="font-size: 1.5em;">+</span>
                </button>
            </div>
            <button type="submit" class="btn btn-primary mb-4">Add Field</button>
        </form>
    </div>
    <!-- Include more columns or sections for additional form field options if needed -->
</div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var requiredCheckbox = document.getElementById('requiredCheckbox');
        var hiddenInput = document.querySelector('input[name="required"]');

        // Set the initial value to 0
        hiddenInput.value = 0;

        // Add event listener for checkbox click
        requiredCheckbox.addEventListener('click', function() {
            hiddenInput.value = this.checked ? 1 : 0;
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var typeSelect = document.getElementById('type');
        var linearScaleFields = document.querySelectorAll('.linear-scale-field');

        // Hide linear scale specific input fields initially
        linearScaleFields.forEach(function(element) {
            element.style.display = 'none';
        });

        typeSelect.addEventListener('change', function() {
            var selectedType = this.value;

            // Show/hide linear scale specific input fields
            if (selectedType === 'linear_scale') {
                linearScaleFields.forEach(function(element) {
                    element.style.display = 'block';
                });
            } else {
                linearScaleFields.forEach(function(element) {
                    element.style.display = 'none';
                });
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var typeSelect = document.getElementById('type');
        var gridOptions = document.getElementById('grid-options');
        var rowButton = document.getElementById('add-row-btn');
        var columnButton = document.getElementById('add-column-btn');
        var rowInputsContainer = document.getElementById('row-inputs-container');
        var columnInputsContainer = document.getElementById('column-inputs-container');

        // Hide row and column buttons label initially
        rowButton.style.display = 'none';
        columnButton.style.display = 'none';
        document.getElementById('row-inputs-container').style.display = 'none';
        document.getElementById('column-inputs-container').style.display = 'none';

        typeSelect.addEventListener('change', function() {
            var selectedType = this.value;
            if (selectedType === 'grid' || selectedType === 'mgrid') {
                gridOptions.style.display = 'block';
                // Show row and column buttons for grid type
                rowButton.style.display = 'block';
                columnButton.style.display = 'block';
                // Add default input fields for row and column
                addRowInput();
                addColumnInput();
                document.getElementById('row-inputs-container').style.display = 'block';
                document.getElementById('column-inputs-container').style.display = 'block';
            } else {
                gridOptions.style.display = 'none';
                // Hide row and column buttons for other types
                rowButton.style.display = 'none';
                columnButton.style.display = 'none';
                // Clear existing input fields for row and column
                clearRowInput();
                clearColumnInput();
                document.getElementById('row-inputs-container').style.display = 'none';
                document.getElementById('column-inputs-container').style.display = 'none';
            }

            var optionsContainer = document.getElementById('options-container');
            var addButton = document.getElementById('add-option-btn');

            optionsContainer.style.display = '';
            optionsContainer.innerHTML = '';
            addButton.style.display = 'none';

            if (selectedType === 'select' || selectedType === 'checkbox' || selectedType === 'multiple_choice') {
                optionsContainer.style.display = 'block';
                addButton.style.display = 'block';
                var numOptions = 1;
                for (var i = 0; i < numOptions; i++) {
                    addOptionInput();
                }
            }
        });

        document.getElementById('add-option-btn').addEventListener('click', function() {
            addOptionInput();
        });

        // Function to add an option input field
        function addOptionInput() {
            var optionsContainer = document.getElementById('options-container');
            var numOptions = optionsContainer.querySelectorAll('.option-group').length;

            var optionsGroup = document.createElement('div');
            optionsGroup.classList.add('mb-3');
            optionsGroup.classList.add('option-group');
            var label = document.createElement('label');
            label.setAttribute('for', 'option' + (numOptions + 1));
            label.classList.add('form-label');
            label.textContent = 'Option ' + (numOptions + 1);
            var input = document.createElement('input');
            input.setAttribute('type', 'text');
            input.setAttribute('class', 'form-control');
            input.setAttribute('id', 'option' + (numOptions + 1));
            input.setAttribute('name', 'options[]');
            input.setAttribute('placeholder', 'Enter option');
            optionsGroup.appendChild(label);
            optionsGroup.appendChild(input);
            optionsContainer.appendChild(optionsGroup);
        }

        // Function to add row input field dynamically
        function addRowInput() {
            var inputField = document.createElement('input');
            inputField.setAttribute('type', 'text');
            inputField.setAttribute('class', 'form-control mb-3');
            inputField.setAttribute('placeholder', 'Row Name');
            inputField.setAttribute('name', 'row_name[]');
            rowInputsContainer.appendChild(inputField);
        }

        // Function to add column input field dynamically
        function addColumnInput() {
            var inputField = document.createElement('input');
            inputField.setAttribute('type', 'text');
            inputField.setAttribute('class', 'form-control mb-3');
            inputField.setAttribute('placeholder', 'Column Name');
            inputField.setAttribute('name', 'column_name[]');
            columnInputsContainer.appendChild(inputField);
        }

        // Function to clear row input field
        function clearRowInput() {
            rowInputsContainer.innerHTML = '';
        }

        // Function to clear column input field
        function clearColumnInput() {
            columnInputsContainer.innerHTML = '';
        }

        // Event listener for adding row input field
        rowButton.addEventListener('click', function() {
            addRowInput();
        });

        // Event listener for adding column input field
        columnButton.addEventListener('click', function() {
            addColumnInput();
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var addOptionButton = document.getElementById('add-option-btn');
        var addRowButton = document.getElementById('add-row-btn');
        var addColumnButton = document.getElementById('add-column-btn');

        document.getElementById('myForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            var form = event.target;
            var formData = new FormData(form);

            // Send AJAX request
            fetch(form.action, {
                    method: form.method,
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Handle response data
                    console.log(data);
                    if (data.success) {
                        // Clear form and related fields immediately
                        clearForm();
                        // Display success message from controller
                        showAlert('success', data.message);
                        // Update form fields with submitted data
                        document.getElementById('form_title').value = data.form_title;
                        document.getElementById('form_desc').value = data.form_desc;

                    } else {
                        // Handle validation errors and other error messages
                        handleErrors(data);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('danger', 'An error occurred'); // Display error message for unexpected errors
                });
        });

        // Function to clear form and related fields
        function clearForm() {
            var form = document.getElementById('myForm');
            var optionsContainer = document.getElementById('options-container');
            var linearScaleFields = document.querySelectorAll('.linear-scale-field');
            var rowInputsContainer = document.getElementById('row-inputs-container');
            var columnInputsContainer = document.getElementById('column-inputs-container');

            // Reset form
            form.reset();

            // Clear options container
            optionsContainer.innerHTML = '';
            //clear linearscalefield
            // Hide linear scale fields and clear their values
            linearScaleFields.forEach(function(element) {
                element.style.display = 'none';
                if (element.type === 'number') {
                    // If it's a number input, set its value to an empty string
                    element.value = '';
                } else {
                    // If it's a text input, set its value to its placeholder value
                    element.value = element.placeholder;
                }
            });

            // Clear row names
            rowInputsContainer.innerHTML = '';

            // Clear column names
            columnInputsContainer.innerHTML = '';

            // Hide add option button
            addOptionButton.style.display = 'none';
            // Hide add row and add column buttons
            addRowButton.style.display = 'none';
            addColumnButton.style.display = 'none';
        }

        // Function to display Bootstrap alert messages
        function showAlert(type, message) {
            // Display alert message immediately
            var alertDiv = document.createElement('div');
            alertDiv.classList.add('alert');
            alertDiv.classList.add('alert-' + type);
            alertDiv.classList.add('col-lg-6');
            alertDiv.classList.add('mx-auto');
            alertDiv.textContent = message;

            var form = document.getElementById('myForm');
            form.parentNode.insertBefore(alertDiv, form.nextSibling); // Insert alert below the form

            // Set timeout to remove the alert after 5 seconds
            setTimeout(function() {
                alertDiv.remove();
            }, 5000);
        }

        // Function to handle validation errors and other error messages
        function handleErrors(data) {
            if (data.errors) {
                // Construct error message from the validation errors
                var errorMessages = '';
                for (var key in data.errors) {
                    errorMessages += data.errors[key][0] + '\n';
                }
                showAlert('danger', errorMessages);
            } else if (data.message) {
                // Display other error messages
                showAlert('danger', data.message);
            } else {
                showAlert('danger', 'Form submission failed'); // Display generic error message
            }
        }
    });
</script>