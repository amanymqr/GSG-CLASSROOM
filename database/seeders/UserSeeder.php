<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
        'name'=>'amany',
        'email'=>'amany@gamil.com',
        'password'=>Hash::make('password'),
        //sha,md5,rsa
        ]);

        // DB::table('users')->insert([
        //     'name'=>'amany',
        //     'email'=>'amany20@gamil.com',
        //     'password'=>Hash::make('password'),
        //     ]);
    }
}
