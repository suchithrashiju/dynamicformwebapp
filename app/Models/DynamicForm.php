<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicForm extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'is_active'];

    public function dynamicFormFields()
    {
        return $this->hasMany(DynamicFormField::class, 'form_id');
    }
    public function formFields()
    {
        return $this->hasMany(FormField::class);
    }

}
