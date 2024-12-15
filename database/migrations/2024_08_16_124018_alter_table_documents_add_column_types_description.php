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
        Schema::table('document_types', function (Blueprint $table) {
            //
            $table->string('type_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('document_types', 'type_description'))
        {
            Schema::table('users', function (Blueprint $table)
            {
                $table->dropColumn('type_description');
            });
        }
        //$table->dropColumn('type_description');
    }
};
