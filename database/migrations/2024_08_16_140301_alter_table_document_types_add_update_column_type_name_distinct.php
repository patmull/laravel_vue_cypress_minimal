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
        if (!Schema::hasColumn('document_types', 'type_name')) {
            Schema::table('document_types', function (Blueprint $table) {
                $table->string('type_name');
            });
        }
        if (!Schema::hasColumn('document_types', 'update_type_name')) {
            Schema::table('document_types', function (Blueprint $table) {
                $table->string('update_type_name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_types', function (Blueprint $table) {
            $table->dropUnique('document_types_type_name_unique');
        });
    }
};
