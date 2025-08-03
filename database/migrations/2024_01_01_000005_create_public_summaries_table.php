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
        Schema::create('public_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users');
            $table->string('title');
            $table->text('summary_content');
            $table->json('statistics')->nullable()->comment('Aggregated statistics from verified reports');
            $table->date('period_start');
            $table->date('period_end');
            $table->string('district')->nullable()->comment('Specific district or null for all districts');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            
            $table->index(['report_category_id', 'is_published']);
            $table->index(['period_start', 'period_end']);
            $table->index('district');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_summaries');
    }
};