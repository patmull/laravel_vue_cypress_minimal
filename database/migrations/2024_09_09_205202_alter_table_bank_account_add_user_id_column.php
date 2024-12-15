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
        if (!Schema::hasTable('bank_accounts')) {
            Schema::rename('bank_account', 'bank_accounts');
        }

        if (Schema::hasTable('bank_accounts')) {

            Schema::table('bank_accounts', function (Blueprint $table) {
                //
                if(!Schema::hasColumn('bank_accounts', 'user_id')) {
                    $table->unsignedBigInteger('user_id');

                    $table->foreign('user_id')->references('id')->on('users');
                }

            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            //
        });
    }
};
