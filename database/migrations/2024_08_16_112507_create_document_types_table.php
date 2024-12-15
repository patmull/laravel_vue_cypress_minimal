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
        try {
            Schema::create('document_types', function (Blueprint $table) {
                $table->id();
                $table->string('type_name');
            });
        } catch (\Illuminate\Database\QueryException $queryException) {
            if ($queryException->getCode() === '42S01') {
                print("Error when creating table. Probably already exists: {$queryException->getMessage()}\n");
            }
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_types');
    }
};
