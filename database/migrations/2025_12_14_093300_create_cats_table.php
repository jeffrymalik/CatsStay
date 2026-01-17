<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Basic Info
            $table->string('name');
            $table->string('breed')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->decimal('weight', 5, 2)->nullable(); // in kg
            $table->string('color')->nullable();
            $table->text('photo')->nullable(); 
            // Health Info
            $table->text('medical_notes')->nullable();
            // Behavior & Care
            $table->text('personality_traits')->nullable();
            $table->text('care_instructions')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cats');
    }
};