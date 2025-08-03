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
        Schema::create('report_template_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_category_id')->constrained()->onDelete('cascade');
            $table->string('field_name')->comment('Human readable field name');
            $table->string('field_key')->comment('Key for storing data');
            $table->enum('field_type', ['text', 'number', 'textarea', 'select', 'date'])->default('text');
            $table->json('field_options')->nullable()->comment('Options for select fields');
            $table->boolean('is_required')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['report_category_id', 'sort_order']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_template_fields');
    }
};