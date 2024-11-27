<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact me</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <link rel="icon" href="{{ asset('images/5.ico') }}" type="image/x-icon">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
    }

    .container {
      margin-top: 50px;
    }


    .required-label {
      font-size: 1.2em;
      /* Adjust the font size as needed */
      color: red;
      /* Make the asterisk red */
      margin-left: 5px;
      /* Add some space between the label and the asterisk */
    }

    /* astrick hide garna */
    .hidden {
      display: none;
      /* Hide the element */
    }

    .signature-pad {
      border: 2px solid #4CAF50;
      /* Green border */
      background-color: #FFFFFF;
      /* White background */
      border-radius: 10px;
      /* Rounded corners */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      /* Shadow for depth */
      margin-bottom: 30px;
      /* Increased margin bottom for better separation */
      padding: 20px;
      /* Added padding for inner space */
    }

    .signature-pad:hover {
      transform: translateY(-2px);
      /* Lift the pad slightly on hover */
      transition: transform 0.3s ease;
      /* Smooth transition */
    }

    .signature-pad::placeholder {
      color: #aaa;
      /* Light gray placeholder text */
    }

    .signature-pad:focus {
      border-color: #007bff;
      /* Blue border color when focused */
      box-shadow: 0 4px 8px rgba(0, 123, 255, 0.1);
      /* Blue shadow when focused */
      outline: none;
      /* Remove outline */
    }

    .signature-pad {
      cursor: url(pen.ico), auto;
      /* Default cursor */
    }

    .signature-pad.eraser-mode {
      cursor: url(eraser.ico), auto;
      /* Cursor for eraser mode */
    }

    .clear-button,
    .eraser-button {
      padding: 8px 16px;
      background-color: #ff6347;
      color: #fff;
      border: none;
      border-radius: 20px;
      margin-bottom: 10px;
      transition: background-color 0.3s ease;
    }

    /* Add margin between buttons */
    .clear-button+.eraser-button {
      margin-left: 100px;
    }

    .clear-button:hover,
    .eraser-button:hover {
      background-color: #d32f2f;
    }


    /* Styling for form title */
    /* Styling for form title */
    .form-title {
      font-size: 36px;
      /* Increase font size */
      font-weight: bold;
      margin-bottom: 20px;
      font-family: 'Arial', sans-serif;
      /* Change font family */
      color: #333;
      /* Change font color */
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
      /* Add text shadow for emphasis */
    }


    /* Styling for form description */
    .form-description {
      font-family: 'Arial', sans-serif;
      font-size: 16px;
      margin-bottom: 20px;
      text-align: justify;
      color: #666;
      /* Justify the text */
    }

    form {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .form-label {
      font-weight: bold;
    }

    .form-control {
      border-radius: 5px;
    }

    .mb-4 {
      margin-bottom: 20px !important;
    }

    .btn-danger {
      background-color: #dc3545;
      border-color: #dc3545;
      font-weight: bold;
    }

    .btn-danger:hover {
      background-color: #c82333;
      border-color: #bd2130;
    }

    .custom-file-label {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .alerts-container {
      max-width: 400px;
      /* Adjust as needed */
      margin: 0 auto;
      /* Center the container */
    }
  </style>
</head>

<body>
  <div class="container-fluid mt-4">
    <div class="row justify-content-center">
      <div class="col-md-8">
        @if ($errors->any())
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
        @endif

        <!-- Display Form Title -->
        <h2 class="form-title text-center">{{ $form_title }}</h2>

        <!-- Display Form Description -->
        <p class="form-description">{{ $form_desc }}</p>



        <form class="w-80" id="myForm" action="{{ route('student.store')}}" method="post">
          @csrf

          @foreach($formFields as $field)
          <div class="droppable">
            @if($field->type == 'text')
            <div class="card mb-4 draggable" id="card">
              <div class="card-body">
                <div class="mb-3">
                  <label for="{{ $field->label }}" class="form-label">{{ $field->label }}<span class="{{ $field->required ? 'required-label' : 'hidden' }}"> *</span></label>
                  <input type="text" placeholder="Enter text" class="form-control form-control-sm" id="{{ strtolower(str_replace(' ', '_', $field->label)) }}" name="{{ $field->label }}">
                </div>
              </div>
            </div>
            @endif

            @if($field->type == 'textarea')
            <div class="card mb-4 draggable" id="card">
              <div class="card-body">
                <div class="mb-3">
                  <label for="{{ $field->label }}" class="form-label">{{ $field->label }}<span class="{{ $field->required ? 'required-label' : 'hidden' }}"> *</span></label>
                  <textarea placeholder="Your response Here" class="form-control form-control-sm" id="{{ strtolower(str_replace(' ', '_', $field->label)) }}" name="{{ $field->label }}"></textarea>
                </div>
              </div>
            </div>
            @endif

            @if($field->type == 'checkbox')
            <div class="card mb-4 draggable" id="card">
              <div class="card-body">
                <div class="mb-3">
                  <label class="form-label">{{ $field->label }}<span class="{{ $field->required ? 'required-label' : 'hidden' }}"> *</span></label>
                  <div class="row">
                    @php
                    $fieldData = json_decode($field->field_data);
                    $options = isset($fieldData->options) ? $fieldData->options : [];
                    $numCols = 3; // Number of columns for options
                    $numOptions = count($options);
                    $colSize = ceil($numOptions / $numCols);
                    @endphp
                    @for ($i = 0; $i < $numCols; $i++) <div class="col">
                      @for ($j = $i * $colSize; $j < min(($i + 1) * $colSize, $numOptions); $j++) <div class="form-check">
                        <input type="checkbox" class="form-check-input checkbox-option" id="{{ strtolower(str_replace(' ', '_', $field->label)) }}" name="{{ $field->label }}[]" value="{{ $options[$j] }}">
                        <label class="form-check-label" for="{{ $field->label }}_{{ $j }}">{{ $options[$j] }}</label>
                  </div>
                  @endfor
                </div>
                @endfor
              </div>
            </div>
          </div>

          @endif


          @if($field->type == 'multiple_choice')
          <div class="card mb-4 draggable" id="card">
            <div class="card-body">
              <div class="mb-3">
                <label class="form-label">{{ $field->label }}<span class="{{ $field->required ? 'required-label' : 'hidden' }}"> *</span></label>
                <div class="row">
                  @php
                  $fieldData = json_decode($field->field_data);
                  $options = isset($fieldData->options) ? $fieldData->options : [];
                  $numCols = 3; // Number of columns for options
                  $numOptions = count($options);
                  $colSize = ceil($numOptions / $numCols);
                  @endphp
                  @for ($i = 0; $i < $numCols; $i++) <div class="col">
                    @for ($j = $i * $colSize; $j < min(($i + 1) * $colSize, $numOptions); $j++) <div class="form-check">
                      <input type="radio" class="form-check-input" value="{{ $options[$j] }}" id="{{ strtolower(str_replace(' ', '_', $field->label)) }}" name="{{ $field->label }}">
                      <label class="form-check-label" for="{{ $field->label }}_{{ $j }}">{{ $options[$j] }}</label>
                </div>
                @endfor
              </div>
              @endfor
            </div>
          </div>
      </div>
      @endif
      @if($field->type == 'image')
      <div class="card mb-4 draggable" id="card">
        <div class="card-body">
          <div class="mb-3">
            <label for="{{ $field->label }}" class="form-label">{{ $field->label }}<span class="{{ $field->required ? 'required-label' : 'hidden' }}"> *</span></label>
            <input type="file" class="form-control form-control-sm" id="{{ strtolower(str_replace(' ', '_', $field->label)) }}" name="{{ $field->label }}" accept="image/*">
          </div>
        </div>
      </div>
      @endif
      @if($field->type == 'select' && !is_null($field->field_data))
      <div class="card mb-4 draggable" id="card">
        <div class="card-body">
          <div class="mb-3">
            <label for="{{ $field->label }}" class="form-label">{{ $field->label }}<span class="{{ $field->required ? 'required-label' : 'hidden' }}"> *</span></label>
            <select class="form-select form-select-sm" id="{{ strtolower(str_replace(' ', '_', $field->label)) }}" name="{{ $field->label }}">
              <option value="">Select an option</option> <!-- Add empty option as a placeholder -->
              @php
              $fieldData = json_decode($field->field_data);
              $options = $fieldData->options ?? [];
              $filteredOptions = array_filter($options); // Remove empty options
              @endphp

              @foreach($filteredOptions as $option)
              <option value="{{ $option }}">{{ $option }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      @endif

      @if($field->type == 'date')
      <div class="card mb-4 draggable" id="card">
        <div class="card-body">
          <div class="mb-3">
            <label for="{{ $field->label }}" class="form-label">{{ $field->label }}<span class="{{ $field->required ? 'required-label' : 'hidden' }}"> *</span></label>
            <input type="date" class="form-control form-control-sm" id="{{ strtolower(str_replace(' ', '_', $field->label)) }}" name="{{ $field->label }}">
          </div>
        </div>
      </div>
      @endif
      @if($field->type == 'time')
      <div class="card mb-4 draggable" id="card">
        <div class="card-body">
          <div class="mb-3">
            <label for="{{ $field->label }}" class="form-label">{{ $field->label }}<span class="{{ $field->required ? 'required-label' : 'hidden' }}"> *</span></label>
            <input type="time" class="form-control form-control-sm" id="{{ strtolower(str_replace(' ', '_', $field->label)) }}" name="{{ $field->label }}">
          </div>
        </div>
      </div>
      @endif
      @if($field->type == 'signature')
      <div class="card mb-4 draggable" id="card">
        <div class="card-body">
          <div class="container">
            <div class="row mb-3">
              <div class="col-12 d-flex align-items-center justify-content-between">
                <label for="{{ $field->label }}" class="form-label">{{ $field->label }}<span class="{{ $field->required ? 'required-label' : 'hidden' }}"> *</span></label>
              </div>
            </div>
            <div class="row">
              <div class="col-12 d-flex justify-content-center">
                <canvas class="signature-pad" name="{{ $field->label }}" id="signature-pad-{{$loop->iteration}}" width="300" height="200"></canvas>
              </div>
            </div>
            <input type="hidden" name="{{ $field->label }}" id="signature-data-{{$loop->iteration}}">
            <div class="row">
              <div class="col-12 d-flex justify-content-center">
                <button type="button" class="clear-button">Clear Signature</button>
                <button type="button" class="eraser-button">Eraser</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif

      @if($field->type == 'file')
      <div class="card mb-4 draggable" id="card">
        <div class="card-body">
          <div class="mb-3">
            <label for="{{ $field->label }}" class="form-label">{{ $field->label }}<span class="{{ $field->required ? 'required-label' : 'hidden' }}"> *</span></label>
            <input type="file" class="form-control form-control-sm" id="{{ strtolower(str_replace(' ', '_', $field->label)) }}" name="{{ $field->label }}">
          </div>
        </div>
      </div>
      @endif
      @if($field->type == 'grid')
      <div class="card mb-4 draggable" id="card">
        <div class="card-body">
          <div class="mb-3">
            <label for="{{ $field->label }}" class="form-label">{{ $field->label }}<span class="{{ $field->required ? 'required-label' : 'hidden' }}"> *</span></label>
            <div class="row">
              <div class="col">
                <!-- Table to display grid -->
                <table class="table">
                  <thead>
                    <tr>
                      <!-- Empty space for first cell -->
                      <th></th>
                      <!-- Display column names -->
                      @php
                      $fieldData = json_decode($field->field_data);
                      $columns = $fieldData->columns ?? [];
                      $rows = $fieldData->rows ?? [];
                      @endphp
                      @foreach($columns as $column)
                      <th class="">{{ $column }}</th>
                      @endforeach
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Display row names and checkboxes -->
                    @foreach($rows as $row)
                    <tr>
                      <!-- Display row name -->
                      <td>{{ $row }}</td>
                      <!-- Display checkboxes for each column -->
                      @foreach($columns as $column)
                      <td>
                        <div class="form-check">
                          <input type="checkbox" class="form-check-input" id="{{ strtolower(str_replace(' ', '_', $field->label)) }}" name="{{ $field->label }}[{{ $row }}][]" value="{{ $column }}">

                        </div>
                      </td>
                      @endforeach
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif

      @if($field->type == 'mgrid')
      <div class="card mb-4 draggable" id="card">
        <div class="card-body">
          <div class="mb-3">
            <label for="{{ $field->label }}" class="form-label">{{ $field->label }}<span class="{{ $field->required ? 'required-label' : 'hidden' }}"> *</span></label>
            <div class="row">
              <div class="col">
                <!-- Table to display grid -->
                <table class="table">
                  <thead>
                    <tr>
                      <!-- Empty space for first cell -->
                      <th></th>
                      <!-- Display column names -->
                      @php
                      $fieldData = json_decode($field->field_data);
                      $columns = $fieldData->columns ?? [];
                      $rows = $fieldData->rows ?? [];
                      @endphp
                      @foreach($columns as $column)
                      <th class="">{{ $column }}</th>
                      @endforeach
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Display row names and checkboxes -->
                    @foreach($rows as $row)
                    <tr>
                      <!-- Display row name -->
                      <td>{{ $row }}</td>
                      <!-- Display radio buttons for each column -->
                      @foreach($columns as $column)
                      <td>
                        <div class="form-check">
                          <input type="radio" class="form-check-input" id="{{ strtolower(str_replace(' ', '_', $field->label)) }}" name="{{ $field->label }}[{{ $row }}]" value="{{ $column }}">
                        </div>
                      </td>
                      @endforeach
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif

      @if($field->type == 'linear_scale')
      <div class="card mb-4 draggable" id="card">
        <div class="card-body">
          @php
          $linearScaleData = json_decode($field->field_data, true);
          @endphp
          <div class="mb-4 text-center">
            <label for="{{ $field->label }}" class="form-label mt-4">{{ $field->label }}
              <span class="{{ $field->required ? 'required-label' : 'hidden' }}"> *</span>
            </label>
          </div>
          <div class="mb-3 d-flex justify-content-between align-items-center">
            <span>{{ $linearScaleData['left_label'] }}</span>
            <span>{{ $linearScaleData['right_label'] }}</span>
          </div>
          <div class="custom-slider">
            <input type="range" id="{{ strtolower(str_replace(' ', '_', $field->label)) }}" name="slider_{{ $field->label }}" min="{{ $linearScaleData['min_value'] }}" max="{{ $linearScaleData['max_value'] }}" step="{{ $linearScaleData['step'] }}" class="form-range" oninput="updateSliderValue(this)">
            <input type="hidden" id="actualValue" name="{{ $field->label }}" value="">
            <div class="slider-value-box" id="sliderValue">null</div>
          </div>
          <div class="mb-3 d-flex justify-content-between">
            <span>{{ $linearScaleData['min_value'] }}</span>
            <span>{{ $linearScaleData['max_value'] }}</span>
          </div>
        </div>
      </div>
      @endif
      <style>
        .custom-slider {
          width: 100%;
          position: relative;
        }

        .custom-slider input[type="range"] {
          width: 100%;
          height: 20px;
          background: linear-gradient(to right, #f0f0f0, #d3d3d3);
          border: none;
          outline: none;
          cursor: pointer;
          appearance: none;
        }

        .custom-slider input[type="range"]::-webkit-slider-thumb {
          appearance: none;
          width: 20px;
          height: 20px;
          background: #04AA6D;
          border-radius: 50%;
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
          cursor: pointer;
          transition: transform 0.2s ease;
        }

        .custom-slider input[type="range"]::-moz-range-thumb {
          width: 20px;
          height: 20px;
          background: #04AA6D;
          border-radius: 50%;
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
          cursor: pointer;
          transition: transform 0.2s ease;
        }

        /* Additional styling for the numerical display */
        .slider-value-box {
          display: flex;
          justify-content: center;
          align-items: center;
          width: 40px;
          height: 30px;
          background-color: #04AA6D;
          color: #fff;
          font-size: 12px;
          border-radius: 4px;
          position: absolute;
          top: -40px;
          left: calc(50% - 20px);
          transform: translateX(-50%);
          /* Center the box horizontally */
        }
      </style>

      @if($field->type == 'email')
      <div class="card mb-4 draggable" id="card">
        <div class="card-body">
          <div class="mb-3">
            <label for="{{ $field->label }}" class="form-label">{{ $field->label }}<span class="{{ $field->required ? 'required-label' : 'hidden' }}"> *</span></label>
            <input type="text" placeholder="Your Email Here" class="form-control form-control-sm" id="{{ strtolower(str_replace(' ', '_', $field->label)) }}" name="{{ $field->label }}">

          </div>
        </div>
      </div>
      @endif
      @if($field->type == 'video')
      <div class="card mb-4 draggable" id="card">
        <div class="card-body">
          <div class="mb-3">
            <label for="{{ $field->label }}" class="form-label">{{ $field->label }}<span class="{{ $field->required ? 'required-label' : 'hidden' }}"> *</span></label>
            <input type="file" class="form-control form-control-sm" id="{{ $field->label }}" id="{{ strtolower(str_replace(' ', '_', $field->label)) }}" accept="video/*">
          </div>
        </div>
      </div>
      @endif
    </div>

    @endforeach


    <div class="col-12 d-flex justify-content-center">
      <button type="submit" class="btn btn-danger mt-4 mb-4">Register</button>
    </div>
    </form>
  </div>
  </div>
  </div>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const slider = document.getElementById('<?php echo strtolower(str_replace(' ', '_', $field->label)); ?>');
      const actualValueInput = document.getElementById('actualValue');
      const form = slider.form;
      form.addEventListener('submit', function(event) {
        // Check if the field is required and the actual value is empty
        if ('{{ $field->required }}' === '1' && actualValueInput.value === '') {
          event.preventDefault(); // Prevent form submission
          // Show an alert message
          alert('{{ $field->label }} is required');
        }
      });
    });


    function updateSliderValue(slider) {
      const valueDisplay = slider.nextElementSibling.nextElementSibling; // Adjusted to skip the hidden input
      valueDisplay.textContent = slider.value;
      document.getElementById('actualValue').value = slider.value;
      // Move the value display box along with the slider handle
      const sliderWidth = slider.offsetWidth;
      const sliderThumbWidth = 20; // Width of the slider thumb
      const thumbPosition = (slider.value - slider.min) / (slider.max - slider.min);
      const valueBoxPosition = thumbPosition * (sliderWidth - sliderThumbWidth);
      valueDisplay.style.left = `${valueBoxPosition}px`;
    }
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var signaturePads = document.querySelectorAll('.signature-pad');
      var clearButtons = document.querySelectorAll('.clear-button');
      var eraserButtons = document.querySelectorAll('.eraser-button');
      var signaturePadInstances = [];

      signaturePads.forEach(function(signaturePad, index) {
        var currentSignaturePad = new SignaturePad(signaturePad, {
          // Pencil options
          minWidth: 2, // Adjust this value as needed for pencil min width
          maxWidth: 2, // Adjust this value as needed for pencil max width
        });
        signaturePadInstances.push(currentSignaturePad);

        // Handle clear button click
        clearButtons[index].addEventListener('click', function() {
          currentSignaturePad.clear();
          document.getElementById('signature-data-' + (index + 1)).value = '';
        });

        // Handle eraser button click
        eraserButtons[index].addEventListener('click', function() {
          toggleEraserMode(currentSignaturePad, index);
        });

        // Reset cursor when mouse leaves signature pad
        signaturePad.addEventListener('mouseleave', function() {
          resetCursor();
        });
      });

      function toggleEraserMode(signaturePad, index) {
        if (signaturePad.penColor === '#FFFFFF') {
          // Switch back to drawing mode
          signaturePad.penColor = '#000'; // Set pen color back to black
          eraserButtons[index].innerText = 'Eraser'; // Change button text back to Eraser
          signaturePads[index].classList.remove('eraser-mode'); // Remove eraser mode class
          resetCursor();

          // Restore pencil options
          signaturePad.minWidth = 2;
          signaturePad.maxWidth = 2;
        } else {
          // Switch to eraser mode
          signaturePad.penColor = '#FFFFFF'; // Set pen color to match background (white)
          eraserButtons[index].innerText = 'Exit Eraser Mode'; // Change button text to Exit Eraser Mode
          signaturePads[index].classList.add('eraser-mode'); // Add eraser mode class
          signaturePad.minWidth = 8; // Adjust this value as needed for eraser min width
          signaturePad.maxWidth = 8; // Adjust this value as needed for eraser max width
          document.body.style.cursor = 'url(eraser.ico), auto';
        }
      }

      function resetCursor() {
        document.body.style.cursor = 'default';
      }

      // Add event listener for form submission
      document.querySelector('form').addEventListener('submit', function(event) {
        signaturePadInstances.forEach(function(signaturePad, index) {
          var signatureData = signaturePad.toDataURL();
          document.getElementById('signature-data-' + (index + 1)).value = signatureData;
        });
      });
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
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


        // Reset form
        form.reset();
        // Clear any displayed error messages
        var errorMessages = document.querySelectorAll('.invalid-feedback');
        errorMessages.forEach(function(errorMessage) {
          errorMessage.remove();
        });

        // Reset form field classes
        var formFields = form.querySelectorAll('.is-invalid');
        formFields.forEach(function(field) {
          field.classList.remove('is-invalid');
        });

        // Reset displayedErrors object
        displayedErrors = {};
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
        form.parentNode.insertBefore(alertDiv, form); // Insert alert below the form

        // Set timeout to remove the alert after 5 seconds
        setTimeout(function() {
          alertDiv.remove();
        }, 5000);
      }

      // Function to handle validation errors and other error messages
      // Keep track of displayed error messages
      var displayedErrors = {};

      function handleErrors(data) {
        if (data.errors) {
          // Loop through validation errors and display them next to respective form fields
          for (var key in data.errors) {
            var errorMessage = data.errors[key][0];
            var errorField = document.getElementById(key);
            if (errorField && !displayedErrors[errorMessage]) {
              errorField.insertAdjacentHTML('beforebegin', '<div class="invalid-feedback" style="display: block;">' + errorMessage + '</div>');
              errorField.classList.add('is-invalid');
              displayedErrors[errorMessage] = true;
            }
          }
        } else if (data.message) {
          // Display other error messages
          showAlert('danger', data.message);
        } else {
          showAlert('danger', 'Form submission failed'); // Display generic error message
        }
      }

    });
  </script>
  <script>
    $(function() {
      // Make draggable elements draggable
      $(".draggable").draggable({
        connectToSortable: ".droppable",
        revert: "invalid", // Snap back to original position if not dropped in droppable container
        helper: 'original', // Use the original element as helper
        cursor: "move", // Change cursor to move when dragging
        zIndex: 1000, // Set higher z-index to ensure the dragged element is on top
        opacity: 0.5, // Set initial opacity
        start: function(event, ui) {
          // Save the original position
          $(this).data('originalPosition', $(this).offset());

          // Apply CSS to the original element to make it transparent
          $(this).css({
            'opacity': '0.5',
            'position': 'absolute',
            'width': $(this).outerWidth() + 'px' // Maintain the original width
          });
        },
        stop: function(event, ui) {
          // Reset CSS after dragging stops
          $(this).css({
            'opacity': '1',
            'position': 'static',
            'width': '' // Reset width
          });
        }
      });

      // Make droppable container accept draggable elements
      $(".droppable").sortable({
        revert: true,
        connectWith: ".droppable", // Allow sorting between droppable containers
        placeholder: "sortable-placeholder",
        revertDuration: 0, // Set revert duration to 0 for immediate dropping
        update: function(event, ui) {
          // Perform actions after sorting is complete, if needed
        }
      });
    });
  </script>


</body>

</html>