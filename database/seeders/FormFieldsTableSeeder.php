<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormFieldsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('form_fields')->insert([
            [
                'label' => 'Text Box',
                'type' => 'text',
                'placeholder' => 'Enter Value',
                'options' => null
            ],
            [
                'label' => 'Email',
                'type' => 'email',
                'placeholder' => 'Enter Email',
                'options' => null
            ],
            [
                'label' => 'Phone Number',
                'type' => 'tel',
                'placeholder' => 'Enter Phone Number',
                'options' => null
            ],
            [
                'label' => 'CheckBox',
                'type' => 'checkbox',
                'placeholder' => null,
                'options' => json_encode(['Checkbox1', 'Checkbox2', 'Checkbox3'])
            ],
            [
                'label' => 'Dropdown',
                'type' => 'select',
                'placeholder' => 'Select',
                'options' => json_encode(['Option1', 'Option2', 'Option3'])
            ],
            [
                'label' => 'Text Area',
                'type' => 'textarea',
                'placeholder' => 'Enter Description',
                'options' => null
            ],
            [
                'label' => 'Radio Button',
                'type' => 'radio',
                'placeholder' => null,
                'options' => json_encode(['Radio1', 'Radio2', 'Radio3'])
            ]
        ]);
    }
}
