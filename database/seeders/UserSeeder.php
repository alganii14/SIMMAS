<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'jabatan' => 'Administrator', // Optional field for 'jabatan'
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Ketua',
            'email' => 'ketua@gmail.com',
            'password' => Hash::make('ketua123'),
            'jabatan' => 'Ketua DKM', // Optional field for 'jabatan'
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Bendahara',
            'email' => 'bendahara@gmail.com',
            'password' => Hash::make('bendahara123'),
            'jabatan' => 'Bendahara DKM', // Optional field for 'jabatan'
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Petugas Qurban',
            'email' => 'qurban@gmail.com',
            'password' => Hash::make('qurban123'),
            'jabatan' => 'Petugas Qurban', // Optional field for 'jabatan'
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
