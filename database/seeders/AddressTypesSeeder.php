<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('address_types')->updateOrInsert([
            'type_name' => 'primary',
        ]);

        DB::table('address_types')->updateOrInsert([
            'type_name' => 'secondary',
        ]);
    }
}
