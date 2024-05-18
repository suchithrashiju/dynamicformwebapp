<?php

namespace App\Http\Controllers;
use App\Models\DynamicForm;
use App\Models\DynamicFormField;
use App\Models\FormField;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use App\Jobs\SendEmailNotification;
use Illuminate\Support\Facades\Queue;

class HomeController extends Controller
{
    public function index()
    {
        $forms = DynamicForm::where('is_active', 1)->get();
        return view('dynamicformlist', compact('forms'));
    }
    public function show($id)
    {
        $dynamicForm = DynamicForm::with('dynamicFormFields')->findOrFail($id);
        $formFields = FormField::all();
        return view('dynamicformview', compact('dynamicForm', 'formFields'));
    }

    public function save(Request $request, $id)
    {
        $inputData = $request->input();
        $formFieldData = $request->input('hid_form_fields');
        unset($inputData['_method']);
        unset($inputData['_token']);
        unset($inputData['hid_form_fields']);
        $submission = new FormSubmission();
        $submission->form_id = $id;
        $submission->submission_data = json_encode($inputData);
        $submission->form_field_data = json_encode($formFieldData);
        $submission->save();
        return redirect()->route('index', $id)->with('success', 'Form submitted successfully!');
    }
}
