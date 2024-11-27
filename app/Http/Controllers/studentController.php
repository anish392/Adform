<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\FormField;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::orderBy('id', 'DESC')->get();
        return view('backend.view_history', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $formFields = FormField::all(); // Retrieve all form fields from the database
        $latestFormField = FormField::latest()->first(); // Retrieve the latest form field record
        $form_title = $latestFormField ? $latestFormField->form_title : ''; // Get the form title from the latest form field, or set it to an empty string if no form fields exist
        $form_desc = $latestFormField ? $latestFormField->form_desc : ''; // Get the form description from the latest form field, or set it to an empty string if no form fields exist
        return view('frontend.welcome', compact('form_title', 'form_desc', 'formFields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Retrieve all form fields from the database
        $formFields = FormField::all();

        // Define validation rules dynamically based on form fields
        $validationRules = [];
        foreach ($formFields as $field) {
            $required = $field->required ? 'required' : 'nullable';
            // Determine the validation rule based on the field type
            $fieldName = str_replace(' ', '_', $field->label); // Modify the field name
            switch ($field->type) {
                case 'text':
                    $validationRules[$fieldName] = $required . '|string';
                    break;
                case 'textarea':
                    $validationRules[$fieldName] = $required . '|string';
                    break;
                case 'multiple_choice':
                case 'select':
                case 'grid':
                case 'mgrid':
                case 'linear_scale':
                    $validationRules[$fieldName] = $required;
                    break;
                case 'email':
                    $validationRules[$fieldName] = $required . '|email';
                    break;
                case 'checkbox':
                    $validationRules[$fieldName] = $required;
                    break;
                case 'image':
                    $validationRules[$fieldName] =  $required . '|image|mimes:jpeg,png,jpg,gif|max:2048';
                    break;
                case 'file':
                    $validationRules[$fieldName] = $required . '|file|max:2048';
                    break;
                case 'date':
                    $validationRules[$fieldName] = $required . '|date_format:Y-m-d';
                    break;
                case 'time':
                    $validationRules[$fieldName] = $required . '|date_format:H:i:s';
                    break;
                case 'signature':
                    $validationRules[$fieldName] = $required . '|string|max:65535';
                    break;
                case 'video':
                    $validationRules[$fieldName] = $required . '|video|mimes:mp4,mpg,mov,wmv|max:2048';
                    break;
                default:
                    // Handle any other field types based on your specific requirements
                    break;
            }
        }

        // Apply validation rules to the request data
        $validator = Validator::make($request->all(), $validationRules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // If validation passes, proceed with processing and storing the data
        $student = new Student();
        foreach ($request->all() as $key => $value) {
            if ($this->isFieldAllowed($key)) {
                $fieldName = str_replace(' ', '_', $key);

                switch ($key) {
                    case 'signature':
                        $signatureFile = $this->convertCanvasToPNG($value);
                        $student->{$fieldName} = $signatureFile;
                        break;
                    case 'image':
                    case 'video':
                    case 'pdf':
                    case 'doc':
                    case 'ppt':
                    case 'xls':
                        if ($request->hasFile($key)) {
                            $file = $request->file($key);
                            $filename = time() . '_' . $file->getClientOriginalName();
                            $file->storeAs('uploads', $filename);
                            $student->{$fieldName} = $filename;
                        }
                        break;
                    case 'email':
                        $student->{$fieldName} = filter_var($value, FILTER_VALIDATE_EMAIL) ? $value : null;
                        break;
                    case 'date':
                        $validatedDate = strtotime($value) ? date('Y-m-d', strtotime($value)) : null;
                        $student->{$fieldName} = $validatedDate;
                        break;
                    case 'time':
                        $validatedTime = strtotime($value) ? date('H:i:s', strtotime($value)) : null;
                        $student->{$fieldName} = $validatedTime;
                        break;
                    default:
                        $student->{$fieldName} = $value;
                }
            }
        }

        // Encode form data into JSON format
        $formData = json_encode($this->prepareFormData($request->all(), $formFields));
        $student->form_data = $formData;

        // Save student record
        $student->save();

        return response()->json([
            'success' => true, 'message' => 'Form field added successfully'

        ]);
    }
    // Function to prepare form data with proper labels
    private function prepareFormData($formData, $formFields)
    {
        $preparedData = [];
        foreach ($formData as $key => $value) {
            $field = $formFields->where('label', str_replace('_', ' ', $key))->first();
            $label = $field ? $field->label : $key;
            $preparedData[$label] = $value;
        }
        return $preparedData;
    }
    private function isFieldAllowed($fieldName)
    {
        // List of allowed field names
        $allowedFields = [
            'text', 'textarea', 'checkbox', 'multiple_choice', 'image',
            'select', 'date', 'time', 'signature', 'file', 'grid', 'mgrid',
            'linear_scale', 'email'
        ];

        return in_array($fieldName, $allowedFields);
    }

    private function convertCanvasToPNG($canvasData)
    {
        // Decode the base64 encoded PNG data
        $decodedData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $canvasData));

        // Check if the directory to save the image exists and is writable
        $directory = public_path('uploads/');
        if (!is_dir($directory) || !is_writable($directory)) {
            // Handle directory non-existence or permission issues
            return null;
        }

        // Generate a unique filename
        $filename = uniqid('signature_') . '.png';
        $filePath = $directory . $filename;

        // Save the decoded data as a PNG file
        if (file_put_contents($filePath, $decodedData)) {
            // Return the filename if the file was saved successfully
            return $filename;
        } else {
            // Handle file saving failure
            return null;
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return redirect()->route('view_history')->with('error', 'Student not found');
        }

        $formFields = FormField::all(); // Retrieve all form fields from the database

        // You can reuse the create view for editing as well
        $latestFormField = FormField::latest()->first(); // Retrieve the latest form field record
        $form_title = $latestFormField ? $latestFormField->form_title : ''; // Get the form title from the latest form field, or set it to an empty string if no form fields exist
        $form_desc = $latestFormField ? $latestFormField->form_desc : ''; // Get the form description from the latest form field, or set it to an empty string if no form fields exist

        return view('frontend.welcome', compact('form_title', 'form_desc', 'formFields', 'student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Retrieve all form fields from the database
        $formFields = FormField::all();

        // Define validation rules dynamically based on form fields
        $validationRules = [];
        foreach ($formFields as $field) {
            $required = $field->required ? 'required' : 'nullable';
            // Determine the validation rule based on the field type
            $fieldName = str_replace(' ', '_', $field->label); // Modify the field name
            switch ($field->type) {
                case 'text':
                    $validationRules[$fieldName] = $required . '|string';
                    break;
                case 'textarea':
                    $validationRules[$fieldName] = $required . '|string';
                    break;
                case 'multiple_choice':
                case 'select':
                case 'grid':
                case 'mgrid':
                case 'linear_scale':
                    $validationRules[$fieldName] = $required;
                    break;
                case 'email':
                    $validationRules[$fieldName] = $required . '|email';
                    break;
                case 'checkbox':
                    $validationRules[$fieldName] = $required;
                    break;
                case 'image':
                    $validationRules[$fieldName] =  $required . '|image|mimes:jpeg,png,jpg,gif|max:2048';
                    break;
                case 'file':
                    $validationRules[$fieldName] = $required . '|file|max:2048';
                    break;
                case 'date':
                    $validationRules[$fieldName] = $required . '|date_format:Y-m-d';
                    break;
                case 'time':
                    $validationRules[$fieldName] = $required . '|date_format:H:i:s';
                    break;
                case 'signature':
                    $validationRules[$fieldName] = $required . '|string|max:65535';
                    break;
                case 'video':
                    $validationRules[$fieldName] = $required . '|video|mimes:mp4,mpg,mov,wmv|max:2048';
                    break;
                default:
                    // Handle any other field types based on your specific requirements
                    break;
            }
        }



        // Apply validation rules to the request data
        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // If validation passes, proceed with processing and storing the data
        $student = new Student();
        foreach ($request->all() as $key => $value) {
            if ($this->isFieldAllowed($key)) {
                $fieldName = str_replace(' ', '_', $key);

                switch ($key) {
                    case 'signature':
                        $signatureFile = $this->convertCanvasToPNG($value);
                        $student->{$fieldName} = $signatureFile;
                        break;
                    case 'image':
                    case 'video':
                    case 'pdf':
                    case 'doc':
                    case 'ppt':
                    case 'xls':
                        if ($request->hasFile($key)) {
                            $file = $request->file($key);
                            $filename = time() . '_' . $file->getClientOriginalName();
                            $file->storeAs('uploads', $filename);
                            $student->{$fieldName} = $filename;
                        }
                        break;
                    case 'email':
                        $student->{$fieldName} = filter_var($value, FILTER_VALIDATE_EMAIL) ? $value : null;
                        break;
                    case 'date':
                        $validatedDate = strtotime($value) ? date('Y-m-d', strtotime($value)) : null;
                        $student->{$fieldName} = $validatedDate;
                        break;
                    case 'time':
                        $validatedTime = strtotime($value) ? date('H:i:s', strtotime($value)) : null;
                        $student->{$fieldName} = $validatedTime;
                        break;
                    default:
                        $student->{$fieldName} = $value;
                }
            }
        }
        $student = Student::find($id);

        if (!$student) {
            return redirect()->route('view_history')->with('error', 'Student not found');
        }

        foreach ($formFields as $field) {
            $fieldName = str_replace(' ', '_', $field->label);
            $student->{$fieldName} = $request->input($fieldName);
        }

        // Encode form data into JSON format
        $formData = json_encode($this->prepareFormData($request->all(), $formFields));
        $student->form_data = $formData;
        $student->save();

        return redirect()->route('view_history')->with('success', 'Form updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return redirect()->route('view_history')->with('error', 'Student not found');
        }

        $student->delete();

        return redirect()->route('view_history')->with('success', 'Student deleted successfully');
    }
}
