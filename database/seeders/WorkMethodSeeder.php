<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('work_methods')->insert([
            ['name' => 'onsite'],
            ['name' => 'remote'],
            ['name' => 'hybrid']
        ]);
    }
}
