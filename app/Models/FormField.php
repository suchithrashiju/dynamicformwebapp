<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'type', 'options'];
    public function dynamicForm()
    {
        return $this->belongsTo(DynamicForm::class);
    }

}
