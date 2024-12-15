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
        if (!Schema::hasColumn('users', 'document_type_id')) {
            Schema::table('documents', function (Blueprint $table) {
                $table->unsignedBigInteger('document_type_id')->nullable();
            });
        }
        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('document_type_id')->references('id')->on('document_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'document_type_id')) {
            Schema::table('documents', function (Blueprint $table) {
                $table->dropColumn('document_type_id');
            });
        }
    }
};
