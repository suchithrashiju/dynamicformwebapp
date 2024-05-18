@extends('layouts.admin-dashboard')

@section('content')
    <div class="container">
        <h1>Create Dynamic Form</h1>
        <a href="{{ route('admin.dynamicForms.index') }}" class="btn btn-primary">List</a>

        <div class="error-message-sec">
            <div id="error-message" class=" text-center text-danger mt-1 mb-1"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form id="dynamic-form" action="{{ route('admin.dynamicForms.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form_name">Form Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="form_name" name="form_name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
                        </div>
                        <div class="col-md-2 mt-5">
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" checked>
                                    <label class="form-check-label" for="is_active">Is Active</label>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mt-5">
                            <div class="form-group">
                                <div id="hidden-form-fields"></div>
                                <button type="submit" class="btn btn-primary" id="submit-form">Create</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <h3>Select Form Fields</h3>
                        <ul id="form-fields-list" class="list-group mb-4">
                            @foreach ($formFields as $field)
                                <li class="list-group-item">
                                    <button type="button" class="btn btn-link form-field-button" {{-- data-field-id="{{ generateUniqueNumber() }}" --}}
                                        data-field-controlid="{{ $field->id }}" data-field-label="{{ $field->label }}"
                                        data-field-type="{{ $field->type }}"
                                        data-field-required="{{ $field->is_required }}"
                                        data-field-placeholder="{{ $field->placeholder }}"
                                        data-field-options="{{ $field->options }}">
                                        {{ $field->label }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-5">
                        <h3>Form Fields</h3>
                        <div id="form-fields-container" class="field-container-group"></div>
                    </div>
                    <div class="col-md-5">
                        <h3>Form Preview</h3>
                        <div id="form-preview-container" class="preview-container"></div>
                    </div>
                </div>
            </div>
        </div>



    </div>

    </div>
    <script>
        function generateRandomString() {
            let result = '';
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const length = 6;
            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            return result;
        }
        document.addEventListener('DOMContentLoaded', function() {
            const formFieldsList = document.getElementById('form-fields-list');
            const formFieldsContainer = document.getElementById('form-fields-container');
            const formPreviewContainer = document.getElementById('form-preview-container');

            formFieldsList.addEventListener('click', function(event) {
                if (event.target.classList.contains('form-field-button')) {
                    let uniqueCode = generateRandomString();
                    const fieldControlId = event.target.dataset.fieldControlid;
                    const fieldId = fieldControlId + "" + uniqueCode;
                    const fieldLabel = event.target.dataset.fieldLabel;
                    const fieldType = event.target.dataset.fieldType;
                    const fieldPlaceholder = event.target.dataset.fieldPlaceholder;
                    const fieldOptions = event.target.dataset.fieldOptions;
                    const isRequired = event.target.dataset.fieldRequired;

                    const fieldHtml = generateFieldHtml(fieldId, fieldLabel, fieldType, fieldPlaceholder,
                        fieldOptions);
                    formFieldsContainer.insertAdjacentHTML('beforeend', fieldHtml);

                    const previewHtml = generatePreviewHtml(fieldId, fieldLabel, fieldType,
                        fieldPlaceholder, fieldOptions);
                    formPreviewContainer.insertAdjacentHTML('beforeend', previewHtml);
                    const hiddenInputsHtml = `
                    <input type="hidden" class="hidfield" name="hid_form_fields[${fieldId}][unique_id]" value="${fieldId}">
                    <input type="hidden" class="hidfield" name="hid_form_fields[${fieldId}][id]" value="${fieldControlId}">
                    <input type="hidden" class="hidfield" name="hid_form_fields[${fieldId}][label]" value="${fieldLabel}">
                    <input type="hidden" class="hidfield" name="hid_form_fields[${fieldId}][type]" value="${fieldType}">
                    <input type="hidden" class="hidfield" name="hid_form_fields[${fieldId}][placeholder]" value="${fieldPlaceholder}">
                    <input type="hidden" class="hidfield" name="hid_form_fields[${fieldId}][options]" value="${fieldOptions}">
                    <input type="hidden" class="hidfield" name="hid_form_fields[${fieldId}][required]" value="${isRequired}">
                `;
                    document.getElementById('hidden-form-fields').insertAdjacentHTML('beforeend',
                        hiddenInputsHtml);
                    const previewElement = document.getElementById(`preview-${fieldId}`);
                    updatePreview(previewElement, fieldId);
                }
            });

            formFieldsContainer.addEventListener('input', function(event) {
                if (event.target.classList.contains('field-input')) {
                    const fieldId = event.target.dataset.fieldId;
                    const previewElement = document.getElementById(`preview-${fieldId}`);
                    updatePreview(previewElement, fieldId);
                }
            });

            formFieldsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('add-option-button')) {
                    const fieldId = event.target.dataset.fieldId;
                    const optionsContainer = document.getElementById(`options-container-${fieldId}`);
                    const optionIndex = optionsContainer.children.length;
                    const optionHtml = `
                <div class="form-group">
                    <input type="text" class="form-control field-input" name="form_fields[${fieldId}][options][${optionIndex}]" placeholder="Option ${optionIndex + 1}" data-field-id="${fieldId}" required>
                </div>`;
                    optionsContainer.insertAdjacentHTML('beforeend', optionHtml);

                    const previewElement = document.getElementById(`preview-${fieldId}`);
                    updatePreview(previewElement, fieldId);
                }
            });

            function generateFieldHtml(id, label, type, placeholder, options) {
                let fieldHtml = `
            <div class="form-group field-container-sec" id="field-container-${id}">
                <h4>Field Name: ${label}</h4>
                <label>Enter Label Name</label>
                <input type="text" class="form-control field-input" name="form_fields[${id}][label]" value="${label}" data-field-id="${id}" placeholder="Label" required>
                <label>Enter Placeholder Text</label>
                <input type="text" class="form-control field-input" name="form_fields[${id}][placeholder]" value="${placeholder}" data-field-id="${id}" placeholder="Placeholder" required>
                <label>Mark As Required</label>
                <input type="checkbox" class="field-input markAsRequire" name="form_fields[${id}][required]" data-field-id="${id}">
                <input type="hidden" name="form_fields[${id}][type]" value="${type}">`;

                if (type === 'checkbox' || type === 'radio' || type === 'select') {
                    fieldHtml += `
                <br><label>Enter Options</label><div class="options-container" id="options-container-${id}">`;
                    const optionsArray = JSON.parse(options);
                    optionsArray.forEach((option, index) => {
                        fieldHtml += `
                    <div class="form-group">
                        <input type="text" class="form-control field-input" name="form_fields[${id}][options][${index}]" value="${option}" data-field-id="${id}" placeholder="Option ${index + 1}" required>
                    </div>`;
                    });
                    fieldHtml +=
                        `
                </div><button type="button" class="btn btn-secondary add-option-button" data-field-id="${id}">Add Option</button>`;
                }

                fieldHtml += `</div>`;
                return fieldHtml;
            }

            formFieldsContainer.addEventListener('change', function(event) {
                if (event.target.classList.contains('markAsRequire')) {
                    const fieldId = event.target.dataset.fieldId;

                    const previewElement = document.getElementById(`preview-${fieldId}`);
                    updatePreview(previewElement, fieldId);
                    const requiredValue = event.target.checked ? 1 : 0;
                    const fieldInput = document.querySelector(
                        `input[name="form_fields[${fieldId}][required]"]`);
                    if (fieldInput) {
                        fieldInput.value = requiredValue;
                    }
                    const hiddenInput = document.querySelector(
                        `input[name="hid_form_fields[${fieldId}][required]"]`);
                    if (hiddenInput) {
                        hiddenInput.value = requiredValue;
                    }


                }
            });

            function generatePreviewHtml(id, label, type, placeholder, options) {
                let previewHtml = `<div class="form-group" id="preview-${id}"><label>${label}`;

                previewHtml += `</label>`;
                if (type === 'text' || type === 'email' || type === 'tel') {
                    previewHtml += `<input type="${type}" class="form-control" placeholder="${placeholder}">`;
                } else if (type === 'textarea') {
                    previewHtml += `<textarea class="form-control" placeholder="${placeholder}"></textarea>`;
                } else if (type === 'checkbox' || type === 'radio') {
                    const optionsArray = JSON.parse(options);
                    optionsArray.forEach(option => {
                        previewHtml += `<div class="form-check">
                                    <input class="form-check-input" type="${type}" value="${option}">
                                    <label class="form-check-label">${option}</label>
                                </div>`;
                    });
                } else if (type === 'select') {
                    const optionsArray = JSON.parse(options);
                    previewHtml += `<select class="form-control"><option value="">Select ${label}</option>`;
                    optionsArray.forEach(option => {
                        previewHtml += `<option value="${option}">${option}</option>`;
                    });
                    previewHtml += `</select>`;
                }

                previewHtml += `</div>`;
                return previewHtml;
            }

            function updatePreview(previewElement, fieldId) {

                const label = document.querySelector(`input[name="form_fields[${fieldId}][label]"]`).value;
                const placeholder = document.querySelector(`input[name="form_fields[${fieldId}][placeholder]"]`)
                    .value;
                const required = document.querySelector(`input[name="form_fields[${fieldId}][required]"]`).checked;
                var isRequired = 0;
                if (required) {
                    isRequired = 1;
                }
                previewElement.querySelector('label').innerText = label;
                const inputElement = previewElement.querySelector('input, textarea, select,checkbox,radio');
                const inputElementChk = previewElement.querySelector('input[type="text"], textarea, select');
                const checkboxElement = previewElement.querySelector('input[type="checkbox"]');
                const radioElements = previewElement.querySelectorAll('input[type="radio"]');

                if (inputElementChk) {
                    inputElementChk.placeholder = placeholder;
                    if (required) {
                        inputElementChk.setAttribute('required', 'required');
                    } else {
                        inputElementChk.removeAttribute('required');
                    }
                }

                if (checkboxElement) {
                    checkboxElement.required = required;
                }

                radioElements.forEach(radio => {
                    radio.required = required;
                });

                const labelElement = previewElement.querySelector('label');
                labelElement.innerHTML = label;
                if (required) {
                    labelElement.innerHTML += '<span style="color: red;"> *</span>';
                }

                const hiddenFieldInput = document.querySelector(
                    `input[name="hid_form_fields[${fieldId}][options]"]`);
                const optionsContainer = document.getElementById(`options-container-${fieldId}`);
                if (optionsContainer) {
                    const options = Array.from(optionsContainer.querySelectorAll('input[type="text"]')).map(
                        optionInput => optionInput
                        .value);
                    if (inputElement.tagName === 'SELECT') {
                        inputElement.innerHTML = '';
                        options.forEach(option => {
                            inputElement.insertAdjacentHTML('beforeend',
                                `<option value="${option}">${option}</option>`);
                        });
                    } else if (inputElement.type === 'radio' || inputElement.type === 'checkbox') {

                        previewElement.innerHTML = `<label>${label}</label>`;

                        options.forEach(option => {
                            previewElement.insertAdjacentHTML('beforeend', `
                        <div class="form-check">
                            <input class="form-check-input" type="${inputElement.type}" value="${option}">
                            <label class="form-check-label">${option}</label>
                        </div>
                    `);
                        });
                    }
                    hiddenFieldInput.value = options;
                }

                document.querySelector(`input[name="hid_form_fields[${fieldId}][label]"]`).value = label;
                document.querySelector(`input[name="hid_form_fields[${fieldId}][placeholder]"]`).value =
                    placeholder;
                document.querySelector(`input[name="hid_form_fields[${fieldId}][required]"]`).value = isRequired;


            }

            const form = document.getElementById('dynamic-form');

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                // alert("Submitting form");
                $('#error-message').html('');

                const formData = new FormData(form);

                if (document.querySelectorAll('.hidfield').length === 0) {
                    alert("Please create at least one dynamic form field.");
                    return false;
                }

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (!data.errors) {
                            alert(data.message);

                            window.location.href = '{{ route('admin.dynamicForms.index') }}';
                        } else {
                            const errorMessageElement = document.getElementById('error-message');
                            if (errorMessageElement) {
                                let errorMessage = '';
                                for (const fieldErrors of Object.values(data.errors)) {
                                    errorMessage += fieldErrors.join(', ') + '\n';
                                }
                                errorMessageElement.textContent = errorMessage;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
@endsection
