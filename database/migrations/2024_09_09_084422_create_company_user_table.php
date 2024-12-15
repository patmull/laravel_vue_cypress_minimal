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
        if (!Schema::hasTable('user_company')) {
            Schema::create('user_company', function (Blueprint $table) {
                $table->foreignId('user_id')->constrained('users');
                $table->foreignId('company_id')->constrained('companies');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_company', function (Blueprint $table) {
            //
        });
    }
};
