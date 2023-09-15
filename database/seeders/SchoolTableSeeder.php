<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('schools')->truncate();
        $json = storage_path() . "/json/schools.json";
        $data = json_decode(file_get_contents($json, true));

        foreach ($data as $obj) {
            \App\Models\School::create([
                'id'      => $obj->id,
                'name'    => $obj->name,
                'address' => $obj->address
            ]);
        }
    }
}
