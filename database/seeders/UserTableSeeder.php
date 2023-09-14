<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->truncate();
        $json = storage_path() . "/json/users.json";
        $data = json_decode(file_get_contents($json, true));

        foreach ($data as $obj) {
            \App\Models\User::create([
                'role_id'   => $obj->role_id,
                'school_id' => $obj->school_id,
                'uid'       => $obj->uid,
                'firstname' => $obj->firstname,
                'lastname'  => $obj->lastname,
                'gender'    => $obj->gender,
                'avatar'    => $obj->avatar,
                'email'     => $obj->email,
                'password'  => $obj->password
            ]);
        }
    }
}
