<?php

// app/helpers.php
function generateUniqueNumber()
{
    $timestamp = microtime(true) * 10000;
    $randomString = bin2hex(random_bytes(4));
    $uniqueId = $timestamp . $randomString;

    return $uniqueId;
}

function generateFormFieldHiddenHtml($id, $field_id, $field_unique_id, $label, $type, $isRequired, $placeholder, $options)
{
    $options_list = "";
    if ($options) {
        $optionsArray = json_decode($options);
        if ($optionsArray) {
            $options_list = implode(",", $optionsArray);
        }

    }

    $fieldHiddenHtml = '<input type="hidden" class="hidfield-edit" name="hid_form_fields[' . $field_unique_id . '][dynamic_frm_field_id]" value="' . $id . '"><input type="hidden" class="hidfield-edit" name="hid_form_fields[' . $field_unique_id . '][unique_id]" value="' . $field_unique_id . '">
        <input type="hidden" class="hidfield-edit" name="hid_form_fields[' . $field_unique_id . '][id]" value="' . $field_id . '">
        <input type="hidden" class="hidfield-edit" name="hid_form_fields[' . $field_unique_id . '][label]" value="' . $label . '">
        <input type="hidden" class="hidfield-edit" name="hid_form_fields[' . $field_unique_id . '][type]" value="' . $type . '">
        <input type="hidden" class="hidfield-edit" name="hid_form_fields[' . $field_unique_id . '][placeholder]" value="' . $placeholder . '">
        <input type="hidden" class="hidfield-edit" name="hid_form_fields[' . $field_unique_id . '][options]" value="' . $options_list . '">
        <input type="hidden" class="hidfield-edit" name="hid_form_fields[' . $field_unique_id . '][required]" value="' . $isRequired . '">';

    return $fieldHiddenHtml;
}
function generateFormFieldHtml($id, $field_id, $field_unique_id, $label, $type, $isRequired, $placeholder, $options)
{
    $requireChecked = $isRequired ? "checked" : "";
    $fieldHtml = '<div class="form-group field-container-sec" id="field-container-' . $field_unique_id . '">';
    $fieldHtml .= '<h4>Field Name: ' . $label . '</h4>';
    $fieldHtml .= '<label>Enter Label Name</label>';
    $fieldHtml .= '<input type="text" class="form-control field-input" name="form_fields[' . $field_unique_id . '][label]" value="' . $label . '" data-field-id="' . $field_unique_id . '" placeholder="Label" required>';
    $fieldHtml .= '<label>Enter Placeholder Text</label>';
    $fieldHtml .= '<input type="text" class="form-control field-input" name="form_fields[' . $field_unique_id . '][placeholder]" value="' . $placeholder . '" data-field-id="' . $field_unique_id . '" placeholder="Placeholder" required>';
    $fieldHtml .= '<label>Mark As Required</label>';
    $fieldHtml .= '<input type="checkbox" class="field-input markAsRequire" name="form_fields[' . $field_unique_id . '][required]" ' . $requireChecked . ' data-field-id="' . $field_unique_id . '">';
    $fieldHtml .= '<input type="hidden" name="form_fields[' . $field_unique_id . '][type]" value="' . $type . '">';

    if ($type === 'checkbox' || $type === 'radio' || $type === 'select') {
        $fieldHtml .= '<br><label>Enter Options</label><div class="options-container" id="options-container-' . $field_unique_id . '">';

        $optionsArray = json_decode($options);
        foreach ($optionsArray as $index => $option) {
            $fieldHtml .= '<div class="form-group">';
            $fieldHtml .= '<input type="text" class="form-control field-input" name="form_fields[' . $field_unique_id . '][options][' . $index . ']" value="' . $option . '" data-field-id="' . $field_unique_id . '" placeholder="Option ' . ($index + 1) . '" required>';
            $fieldHtml .= '</div>';
        }

        $fieldHtml .= '</div><button type="button" class="btn btn-secondary add-option-button" data-field-id="' . $field_unique_id . '">Add Option</button>';
    }

    $fieldHtml .= '</div>';
    return $fieldHtml;
}

function generateFormPreviewHtml($id, $field_id, $field_unique_id, $label, $fieldType, $isRequired, $placeholder, $options)
{
    $html = '<div class="form-group" id="preview-' . $field_unique_id . '">';
    $html .= '<label>' . $label;
    $uniquename =  $label.$field_unique_id;
    if ($isRequired) {
        $html .= ' <span class="text-danger">*</span>';
    }
    $html .= '</label>';
    $optionsArray = json_decode($options, true);
    switch ($fieldType) {
        case 'checkbox':
            foreach ($optionsArray as $option) {
                $html .= '<div class="form-check">';
                $html .= '<input type="checkbox" class="form-check-input" name="' . $uniquename . '[]" value="' . $option . '"';
                if ($isRequired) {
                    $html .= ' required';
                }
                $html .= '>';
                $html .= '<label class="form-check-label">' . $option . '</label>';
                $html .= '</div>';
            }
            break;

        case 'radio':
            foreach ($optionsArray as $option) {
                $html .= '<div class="form-check">';
                $html .= '<input type="radio" class="form-check-input" name="' . $uniquename . '" value="' . $option . '"';
                if ($isRequired) {
                    $html .= ' required';
                }
                $html .= '>';
                $html .= '<label class="form-check-label">' . $option . '</label>';
                $html .= '</div>';
            }
            break;

        case 'select':

                $html .= '<div class="form-check">';
                $html .= '<label>' . $label . '</label>';
                $html .= '<select class="form-control" name="' . $uniquename . '"';
                if ($isRequired) {
                    $html .= ' required';
                }
                $html .= '>';
                foreach ($optionsArray as $option) {
                    $html .= '<option value="' . $option . '">' . $option . '</option>';
                }
                $html .= '</select>';
                $html .= '</div>';

            break;

        case 'text':
            $html .= '<div class="form-check">';
            $html .= '<input type="text" class="form-control" name="' . $uniquename . '" value="" placeholder="' . $placeholder . '"';
            if ($isRequired) {
                $html .= ' required';
            }
            $html .= '>';
            $html .= '</div>';

            break;
        case 'email':
            $html .= '<div class="form-check">';
            $html .= '<input type="email" class="form-control" name="' . $uniquename . '" value="" placeholder="' . $placeholder . '"';
            if ($isRequired) {
                $html .= ' required';
            }
            $html .= '>';
            $html .= '</div>';

            break;
        case 'tel':
            $html .= '<div class="form-check">';
            $html .= '<input type="tel" class="form-control" name="' . $uniquename . '" value="" placeholder="' . $placeholder . '"';
            if ($isRequired) {
                $html .= ' required';
            }
            $html .= '>';
            $html .= '</div>';

            break;
        case 'textarea':
            $html .= '<div class="form-check">';
            $html .= '<textarea class="form-control" name="' . $uniquename . '" value="" placeholder="' . $placeholder . '"';
            if ($isRequired) {
                $html .= ' required';
            }
            $html .= '> </textarea>';
            $html .= '</div>';

            break;
        default:
            $html .= '<p>Unsupported field type: ' . $fieldType . '</p>';
            break;
    }

    $html .= '</div>';
    return $html;
}

function generateFormViewHtml($id, $field_id, $field_unique_id, $label, $fieldType, $isRequired, $placeholder, $options)
{
    $html = '<div class="form-group" id="preview-' . $field_unique_id . '">';
    $html .= '<label>' . $label;
    $unique_name =  $label.$field_unique_id;
    if ($isRequired) {
        $html .= ' <span class="text-danger">*</span>';
    }
    $html .= '</label>';
    $optionsArray = json_decode($options, true);
    $optcls = "";
    $chkoptcls = "";
    switch ($fieldType) {
        case 'checkbox':
            if ($isRequired) {
                $chkoptcls = ' checkbox-option';
            }
            foreach ($optionsArray as $option) {
                $html .= '<div class="form-check">';
                $html .= '<input type="checkbox" class="form-check-input ' . $chkoptcls . '" name="' . $unique_name . '[]" value="' . $option . '"';

                $html .= '>';
                $html .= '<label class="form-check-label">' . $option . '</label>';
                $html .= '</div>';
            }
            break;

        case 'radio':
            if ($isRequired) {
                $optcls = ' radio-option';
            }
            foreach ($optionsArray as $option) {
                $html .= '<div class="form-check">';
                $html .= '<input type="radio" class="form-check-input ' . $optcls . '" name="' . $unique_name . '" value="' . $option . '"';

                $html .= '>';
                $html .= '<label class="form-check-label">' . $option . '</label>';
                $html .= '</div>';
            }
            break;

        case 'select':
                $html .= '<div class="form-check">';
                $html .= '<label>' . $label . '</label>';
                $html .= '<select class="form-control" name="' . $unique_name . '"';
                if ($isRequired) {
                    $html .= ' required';
                }
                $html .= '>';
                foreach ($optionsArray as $option) {
                    $html .= '<option value="' . $option . '">' . $option . '</option>';
                }
                $html .= '</select>';
                $html .= '</div>';

            break;

        case 'text':
            $html .= '<div class="form-check">';
            $html .= '<input type="text" class="form-control" name="' . $unique_name . '" value="" placeholder="' . $placeholder . '"';
            if ($isRequired) {
                $html .= ' required';
            }
            $html .= '>';
            $html .= '</div>';

            break;
        case 'email':
            $html .= '<div class="form-check">';
            $html .= '<input type="email" class="form-control" name="' . $unique_name . '" value="" placeholder="' . $placeholder . '"';
            if ($isRequired) {
                $html .= ' required';
            }
            $html .= '>';
            $html .= '</div>';

            break;
        case 'tel':
            $html .= '<div class="form-check">';
            $html .= '<input type="tel" class="form-control tel_field" name="' . $unique_name . '" value="" placeholder="' . $placeholder . '"';
            if ($isRequired) {
                $html .= ' required';
            }
            $html .= '>';
            $html .= '</div>';

            break;
        case 'textarea':
            $html .= '<div class="form-check">';
            $html .= '<textarea class="form-control" name="' . $unique_name . '" value="" placeholder="' . $placeholder . '"';
            if ($isRequired) {
                $html .= ' required';
            }
            $html .= '> </textarea>';
            $html .= '</div>';

            break;
        default:
            $html .= '<p>Unsupported field type: ' . $fieldType . '</p>';
            break;
    }

    $html .= '</div>';
    return $html;
}
