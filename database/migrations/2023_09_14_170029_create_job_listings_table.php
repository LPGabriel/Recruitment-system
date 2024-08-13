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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('status');
            $table->string('title');
            $table->text('content');
            $table->string('location');
            $table->boolean('confidencial');
            $table->decimal('salary', 10, 2);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('job_listing_type_id')->constrained('job_listing_types')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('job_listing_category_id')->constrained('job_listing_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->date('posting_date');
            $table->date('expiration_date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
