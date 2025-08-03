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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('report_category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('data')->comment('Dynamic form data based on template fields');
            $table->enum('status', ['draft', 'submitted', 'verified', 'rejected'])->default('draft');
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->text('verification_notes')->nullable();
            $table->date('report_date')->comment('Date for which this report is created');
            $table->string('district')->comment('Kecamatan where this report is from');
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['report_category_id', 'status']);
            $table->index(['district', 'report_date']);
            $table->index('status');
            $table->index('report_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};