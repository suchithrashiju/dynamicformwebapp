<?php

namespace App\Http\Controllers;

use App\Models\DynamicForm;
use App\Models\DynamicFormField;
use App\Models\FormField;
use Illuminate\Http\Request;
use App\Jobs\SendEmailNotification;
use Illuminate\Support\Facades\Queue;
class DynamicFormController extends Controller
{
    public function index()
    {
        $forms = DynamicForm::all();
        return view('admin.dynamicForms.index', compact('forms'));
    }

    public function create()
    {
        $formFields = FormField::where('is_active', 1)->get();
        return view('admin.dynamicForms.create', compact('formFields'));
    }

    public function store(Request $request)
    {
        $rules = [
            'form_name' => 'required|string|max:255|unique:dynamic_forms,form_name',
            'description' => 'nullable|string',
            'is_active' => 'nullable',
            'hid_form_fields.*.id' => 'required',
            'hid_form_fields.*.unique_id' => 'required',
            'hid_form_fields.*.label' => 'required|string|max:255',
            'hid_form_fields.*.type' => 'required|string|in:text,email,tel,textarea,checkbox,radio,select', // Add more types if needed
            'hid_form_fields.*.placeholder' => 'nullable|string|max:255',
            'hid_form_fields.*.options' => 'nullable|string', // You may need more specific validation rules for options
            'hid_form_fields.*.required' => 'nullable|boolean',
        ];

        $messages = [
            'form_name.required' => 'The form name is required.',
            'form_name.string' => 'The form name must be a string.',
            'form_name.max' => 'The form name may not be greater than 255 characters.',
            'hid_form_fields.*.label.required' => 'Each form field must have a label.',
            'hid_form_fields.*.label.string' => 'Each form field label must be a string.',
            'hid_form_fields.*.label.max' => 'Each form field label may not be greater than 255 characters.',
            'hid_form_fields.*.type.required' => 'Each form field must have a type.',
            'hid_form_fields.*.type.string' => 'Each form field type must be a string.',
            'hid_form_fields.*.type.in' => 'Each form field type must be one of the following: text, email, tel,textarea,checkbox, radio, select.',
            'hid_form_fields.*.placeholder.string' => 'Each form field placeholder must be a string.',
            'hid_form_fields.*.placeholder.max' => 'Each form field placeholder may not be greater than 255 characters.',
            'hid_form_fields.*.options.string' => 'Each form field options must be a string.',
            'hid_form_fields.*.required.boolean' => 'Each form field required field must be true or false.',
        ];

        $validator = validator($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();


        $dynamicForm = new DynamicForm();
        $dynamicForm->form_name = $request->input('form_name');
        $dynamicForm->description = $request->input('description');
        $dynamicForm->is_active = $request->has('is_active');

        $dynamicForm->save();

        foreach ($validatedData['hid_form_fields'] as $fieldData) {

            if($fieldData['options'])
            {
                $options = explode(",",$fieldData['options']);
            }

            $dynamicForm->dynamicFormFields()->create([
                'form_id' => $dynamicForm->id,
                'form_field_id' => $fieldData['id'],
                'form_unique_id' => $fieldData['unique_id'],
                'label' => $fieldData['label'],
                'placeholder' => $fieldData['placeholder'] ?? null,
                'required' => $fieldData['required'] ?? true,
                'options' => json_encode($options?? null),
                'form_field_details' => $fieldData['form_field_details'] ?? null,
            ]);
        }

        $formData = [
            'recipient_email' => env('EMAIL_RECIPIENT'),
            'subject' => 'New Dynamic Form Successfully Created.',
            'data' => [
                'form_name' => $validatedData['form_name'],
            ],
        ];
        SendEmailNotification::dispatch($formData)->onQueue('emails');
        return response()->json(['message' => 'Form created successfully'], 200);
    }

    public function edit($id)
    {
        $dynamicForm = DynamicForm::with('dynamicFormFields')->findOrFail($id);
        $formFields = FormField::all();
        return view('admin.dynamicForms.edit', compact('dynamicForm', 'formFields'));
    }

    public function update(Request $request, $id)
    {

        $dynamicForm = DynamicForm::findOrFail($id);
        $rules = [
            'form_name' => 'required|string|max:255|unique:dynamic_forms,form_name,' . $id,
            'hid_form_fields.*.id' => 'required',
            'description' => 'nullable|string',
            'is_active' => 'nullable',
            'hid_form_fields.*.dynamic_frm_field_id' => 'nullable',
            'hid_form_fields.*.unique_id' => 'required',
            'hid_form_fields.*.label' => 'required|string|max:255',
            'hid_form_fields.*.type' => 'required|string|in:text,email,tel,textarea,checkbox,radio,select', // Add more types if needed
            'hid_form_fields.*.placeholder' => 'nullable|string|max:255',
            'hid_form_fields.*.options' => 'nullable|string', // You may need more specific validation rules for options
            'hid_form_fields.*.required' => 'nullable|boolean',
        ];

        $messages = [
            'form_name.required' => 'The form name is required.',
            'form_name.string' => 'The form name must be a string.',
            'form_name.max' => 'The form name may not be greater than 255 characters.',
            'hid_form_fields.*.label.required' => 'Each form field must have a label.',
            'hid_form_fields.*.label.string' => 'Each form field label must be a string.',
            'hid_form_fields.*.label.max' => 'Each form field label may not be greater than 255 characters.',
            'hid_form_fields.*.type.required' => 'Each form field must have a type.',
            'hid_form_fields.*.type.string' => 'Each form field type must be a string.',
            'hid_form_fields.*.type.in' => 'Each form field type must be one of the following: text, email, tel,textarea,checkbox, radio, select.',
            'hid_form_fields.*.placeholder.string' => 'Each form field placeholder must be a string.',
            'hid_form_fields.*.placeholder.max' => 'Each form field placeholder may not be greater than 255 characters.',
            'hid_form_fields.*.options.string' => 'Each form field options must be a string.',
            'hid_form_fields.*.required.boolean' => 'Each form field required field must be true or false.',
        ];

        $validator = validator($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $dynamicForm->form_name = $validatedData['form_name'];
        $dynamicForm->description = $validatedData['description'] ?? null;
        $dynamicForm->is_active = isset($validatedData['is_active']) ? ($validatedData['is_active'] ? 1 : 0) : 0;


        foreach ($validatedData['hid_form_fields'] as $fieldData) {
            $options = $fieldData['options'] ? explode(",", $fieldData['options']) : null;
                $dynamicForm->dynamicFormFields()->updateOrCreate(
                    ['id' => $fieldData['dynamic_frm_field_id']],
                    [
                        'form_id' => $id,
                        'form_field_id' => $fieldData['id'],
                        'form_unique_id' => $fieldData['unique_id'],
                        'label' => $fieldData['label'],
                        'placeholder' => $fieldData['placeholder'] ?? null,
                        'required' => $fieldData['required'] ?? true,
                        'options' =>json_encode($options?? null),
                        'form_field_details' => $fieldData['form_field_details'] ?? null,
                    ]

                );

        }

        $dynamicForm->save();

        return response()->json(['message' => 'Form updated successfully'], 200);
    }
    public function destroy($id)
    {
        $dynamicForm = DynamicForm::findOrFail($id);
        $dynamicForm->dynamicFormFields()->delete();
        $dynamicForm->delete();

        return redirect()->route('admin.dynamicForms.index')->with('success', 'Form deleted successfully');    }

}
