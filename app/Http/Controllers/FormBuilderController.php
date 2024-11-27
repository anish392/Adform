<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FormField;

class FormBuilderController extends Controller
{
    /**
     * Display the form builder interface.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $latestFormField = FormField::latest()->first(); // Retrieve the latest form field record
        $form_title = $latestFormField ? $latestFormField->form_title : ''; // Get the form title from the latest form field, or set it to an empty string if no form fields exist
        $form_desc = $latestFormField ? $latestFormField->form_desc : ''; // Get the form description from the latest form field, or set it to an empty string if no form fields exist
        return view('backend.Home', compact('form_title', 'form_desc'));
    }

    /**
     * Store a new form field.
     *
    /**
     * Store a new form field.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'label' => 'required|string',
            'type' => 'required|string',
            'form_title' => 'required|string',
            'form_desc' => 'required|string',
            'required' => 'nullable|boolean',
        ]);

        // If the selected field type requires options, validate them
        if (in_array($request->input('type'), ['select', 'checkbox', 'multiple_choice']) && $request->has('options')) {
            // Ensure at least one option is provided
            $validator->after(function ($validator) use ($request) {
                $options = $request->input('options');
                $optionsCount = count(array_filter($options));

                if ($optionsCount < 1) {
                    $validator->errors()->add('options', 'At least one option is required');
                } else {
                    // Check only the filled options for string validation
                    foreach ($options as $key => $option) {
                        if (!empty($option)) {
                            if (!is_string($option)) {
                                $validator->errors()->add('options.' . $key, 'Options must be strings');
                            }
                        }
                    }
                }
            });
        }
        // If the selected field type is 'grid' or 'mgrid', validate row and column names
        if (in_array($request->input('type'), ['grid', 'mgrid']) && $request->has('row_name') && $request->has('column_name')) {
            // Ensure at least one row and one column are provided
            $validator->after(function ($validator) use ($request) {
                $rowNames = $request->input('row_name');
                $columnNames = $request->input('column_name');
                $rowCount = count(array_filter($rowNames));
                $columnCount = count(array_filter($columnNames));

                if ($rowCount < 1 && $columnCount < 1) {
                    $validator->errors()->add('row_column', 'At least one row and one column are required');
                } else {
                    if ($rowCount < 1) {
                        $validator->errors()->add('row_column', 'Fill at least one row');
                    } elseif ($columnCount < 1) {
                        $validator->errors()->add('row_column', 'Fill at least one column');
                    } else {
                        // Validate row names if provided and not empty
                        if (!empty($rowNames)) {
                            foreach ($rowNames as $rowName) {
                                if (!empty($rowName) && !is_string($rowName)) {
                                    $validator->errors()->add('row_name', 'Row names must be strings');
                                    break;
                                }
                            }
                        }

                        // Validate column names if provided and not empty
                        if (!empty($columnNames)) {
                            foreach ($columnNames as $columnName) {
                                if (!empty($columnName) && !is_string($columnName)) {
                                    $validator->errors()->add('column_name', 'Column names must be strings');
                                    break;
                                }
                            }
                        }
                    }
                }
            });
        }


        // If the selected field type is 'linear_scale', validate min_value, max_value, and step
        if ($request->input('type') === 'linear_scale') {
            $validator->sometimes('min_value', 'required|numeric', function ($input) {
                return $input->type === 'linear_scale';
            });

            $validator->sometimes('max_value', 'required|numeric', function ($input) {
                return $input->type === 'linear_scale';
            });

            $validator->sometimes('step', 'required|numeric', function ($input) {
                return $input->type === 'linear_scale';
            });

            $validator->sometimes('left_label', 'string|nullable', function ($input) {
                return $input->type === 'linear_scale';
            });

            $validator->sometimes('right_label', 'string|nullable', function ($input) {
                return $input->type === 'linear_scale';
            });
        }

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Determine the 'required' value
        $required = $request->filled('required') ? 1 : 0;

        // Create a new form field
        $formField = new FormField();
        $formField->label = $request->input('label');
        $formField->form_title = $request->input('form_title');
        $formField->form_desc = $request->input('form_desc');
        $formField->type = $request->input('type');
        $formField->required = $required;

        // Serialize the field options data and store it in the field_data column
        $fieldData = [];

        if ($request->input('type') === 'select' || $request->input('type') === 'checkbox' || $request->input('type') === 'multiple_choice') {
            $fieldData['options'] = $request->input('options');
        }

        if ($request->input('type') === 'grid'  || $request->input('type') === 'mgrid') {
            $fieldData['rows'] = $request->input('row_name');
            $fieldData['columns'] = $request->input('column_name');
        }

        if ($request->input('type') === 'linear_scale') {
            $fieldData['min_value'] = $request->input('min_value');
            $fieldData['max_value'] = $request->input('max_value');
            $fieldData['step'] = $request->input('step');
            $fieldData['left_label'] = $request->input('left_label');
            $fieldData['right_label'] = $request->input('right_label');
        }

        $formField->field_data = json_encode($fieldData);

        $formField->save();

        return response()->json([
            'success' => true, 'message' => 'Form field added successfully', 'form_title' => $formField->form_title,
            'form_desc' => $formField->form_desc,
        ]);
    }
}
