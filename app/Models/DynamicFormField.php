<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicFormField extends Model
{
    use HasFactory;
    protected $fillable = ['form_id', 'form_field_id','form_unique_id','label', 'placeholder', 'required', 'type', 'options', 'form_field_details'];

    public function dynamicForm()
    {
        return $this->belongsTo(DynamicForm::class);
    }

    public function formField()
    {
        return $this->belongsTo(FormField::class, 'form_field_id');
    }


}
