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
        Schema::table('candidates', function (Blueprint $table) {
            $table->json('social_media')->nullable();
            $table->string('cv')->nullable();
            $table->text('bio')->nullable();
            $table->string('portfolio')->nullable();
            $table->json('academic_education')->nullable();
            $table->json('professional_experiences')->nullable();
            $table->json('courses')->nullable();
            $table->json('additional_information')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn(array_merge([
                'bio',
                'social_media',
                'salary_expectation',
                'cv',
                'portfolio',
                'academic_education',
                'professional_experiences',
                'courses',
                'additional_information',
            ]));
        });
    }
};
