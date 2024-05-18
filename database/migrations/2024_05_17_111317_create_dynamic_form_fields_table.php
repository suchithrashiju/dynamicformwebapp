<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dynamic_form_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('form_field_id');
            $table->string('form_unique_id');
            $table->string('label');
            $table->string('placeholder')->nullable();
            $table->boolean('required')->default(true);
            $table->json('options')->nullable();
            $table->text('form_field_details')->nullable(); // Additional details for the form fields
            $table->timestamps();

            $table->foreign('form_id')->references('id')->on('dynamic_forms')->onDelete('cascade');
            $table->foreign('form_field_id')->references('id')->on('form_fields')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_form_fields');
    }
};
