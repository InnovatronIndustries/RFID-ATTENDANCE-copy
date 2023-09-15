<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('roles')->truncate();
        $json = storage_path() . "/json/roles.json";
        $data = json_decode(file_get_contents($json, true));

        foreach ($data as $obj) {
            \App\Models\Role::create([
                'id'   => $obj->id,
                'name' => $obj->name
            ]);
        }
    }
}
