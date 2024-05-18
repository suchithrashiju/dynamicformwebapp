@extends('layouts.home')

@section('content')
    <div class="container">
        <h1>{{ $dynamicForm->form_name }}</h1>
        <a href="{{ route('index') }}" class="btn btn-primary">Back</a>

        <br>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <form id="myform" action="{{ route('saveDynamicForm', $dynamicForm->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <p>{{ $dynamicForm->description }}</p>

                            </div>
                        </div>

                        <div id="hidden-form-fields-edit">
                            @foreach ($dynamicForm->dynamicFormFields as $field)
                                {!! generateFormFieldHiddenHtml(
                                    $field->id,
                                    $field->form_field_id,
                                    $field->form_unique_id,
                                    $field->label,
                                    $field->formField->type,
                                    $field->required,
                                    $field->placeholder,
                                    $field->options,
                                ) !!}
                            @endforeach
                        </div>
                        <div class="col-md-12 mt-5">
                            <div id="form-preview-container" class="preview-container">
                                @foreach ($dynamicForm->dynamicFormFields as $field)
                                    {!! generateFormViewHtml(
                                        $field->id,
                                        $field->form_field_id,
                                        $field->form_unique_id,
                                        $field->label,
                                        $field->formField->type,
                                        $field->required,
                                        $field->placeholder,
                                        $field->options,
                                    ) !!}
                                @endforeach
                                <button type="button" class="btn btn-primary" id="submit-form">Submit</button>
                            </div>
                        </div>


                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#submit-form').click(function(event) {

                var radioChecked = true;
                var checkboxChecked = true;
                if ($('.radio-option').length > 0) {
                    radioChecked = $('input[type="radio"]:checked').length > 0;
                }
                if ($('.checkbox-option').length > 0) {
                    checkboxChecked = $('input[type="checkbox"]:checked').length > 0;
                }
                if (!radioChecked || !checkboxChecked) {
                    alert('Please fill all mandatory fields');
                    return false;
                }

                $('#myform').submit();
            });

            $('#myform').submit(function() {
                if ($('.radio-option').length > 0) {
                    if ($('.radio-option:checked').length === 0) {
                        $('.radio-option').prop('required', true);
                    } else {
                        $('.radio-option').prop('required', false);
                    }
                }
                if ($('.checkbox-option').length > 0) {
                    if ($('.checkbox-option:checked').length === 0) {
                        $('.checkbox-option').prop('required', true);
                    } else {
                        $('.checkbox-option').prop('required', false);
                    }
                }
            });
        });
        $('.tel_field').on('input', function() {
            var value = $(this).val();
            var newValue = value.replace(/[^0-9\-()\s]/g, '');
            $(this).val(newValue);
        });
    </script>
@endsection
