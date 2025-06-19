<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kasi= User::create([
            'name'  => 'Mufidah Hanum, S.H.',
            'email' => 'hanum@gmail.com',
             'role'  => 'kasi',
            'password' => bcrypt('12345678'),
        ]);
        $kasi->assignRole('kasi');

            $petugas= User::create([
            'name'  => 'Ramadhan Purba Atmaja',
            'email' => 'romi@gmail.com',
            'role'  => 'petugas',
            'password' => bcrypt('12345678'),
        ]);
        $petugas->assignRole('petugas');

            $pelayanan= User::create([
            'name'  => 'Rani',
            'email' => 'rani@gmail.com',
            'role'  => 'pelayanan',
            'password' => bcrypt('12345678'),
        ]);
        $pelayanan->assignRole('pelayanan');

        $kabid= User::create([
            'name'  => 'Mohammad Mahfud, S.Sos.',
            'email' => 'mahfud@gmail.com',
            'role'  => 'kabid',
            'password' => bcrypt('12345678'),
        ]);
        $kasi->assignRole('kabid');


    }
}
