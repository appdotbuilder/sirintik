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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['superadmin', 'admin_bidang', 'admin_kecamatan'])->default('admin_kecamatan');
            $table->string('district')->nullable()->comment('Kecamatan for admin_kecamatan role');
            $table->string('bidang')->nullable()->comment('Bidang for admin_bidang role');
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'district', 'bidang', 'is_active']);
        });
    }
};