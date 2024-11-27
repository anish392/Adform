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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Add columns dynamically based on form fields
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('text_field')->nullable(); // For Short Text
            $table->text('textarea_field')->nullable(); // For Long Text
            $table->boolean('checkbox_field')->nullable(); // For Checkbox
            $table->json('multiple_choice_field')->nullable(); // For Multiple choice
            $table->string('image_field')->nullable(); // For Image
            $table->string('select_field')->nullable(); // For Drop-down
            $table->date('date_field')->nullable(); // For Date
            $table->time('time_field')->nullable(); // For Time
            $table->binary('signature_field')->nullable(); // For Signature
            $table->string('file_field')->nullable(); // For File Upload
            $table->json('grid_field')->nullable(); // For Grid
            $table->integer('linear_scale_field')->nullable(); // For Linear Scale
            $table->text('paragraph_field')->nullable(); // For Paragraph
            $table->string('video_field')->nullable(); // For Video

            // Add conditions for other field types as needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
