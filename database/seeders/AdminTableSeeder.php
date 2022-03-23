<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'uuid' => Str::uuid(),
            'username' => 'waiyan',
            'email' => 'yanlay129@gmail.com',
            'password' => bcrypt('password')
        ]);
    }
}
