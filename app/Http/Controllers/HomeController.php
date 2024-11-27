<?php

namespace App\Http\Controllers;

use App\Models\FormField;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    { {
        $latestFormField = FormField::latest()->first(); // Retrieve the latest form field record
        $form_title = $latestFormField ? $latestFormField->form_title : ''; // Get the form title from the latest form field, or set it to an empty string if no form fields exist
        $form_desc = $latestFormField ? $latestFormField->form_desc : ''; // Get the form description from the latest form field, or set it to an empty string if no form fields exist
        return view('backend.Home', compact('form_title', 'form_desc'));
        }
    }
}
