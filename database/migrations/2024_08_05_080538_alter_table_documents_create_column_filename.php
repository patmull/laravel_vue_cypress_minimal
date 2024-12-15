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
        Schema::table('documents', function (Blueprint $table) {
            $table->string('file_name_employer_original')->nullable(true);
            $table->string('file_name_employee_original')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'file_name_employee_original'))
        {
            Schema::table('users', function (Blueprint $table)
            {
                $table->dropColumn('file_name_employee_original');
            });
        }
    }
};
