<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SubmissionListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('submission_lists')->insert([
            [
                'submission_name' => 'Pengajuan Verlok 1',
                'email' => 'user1@example.com',
                'nohp' => '081234567890',
                'namappat' => 'PPAT Surya',
                'nosertifikat' => '123/ABC/2023',
                'latitude' => '-6.200000',
                'longitude' => '106.816666',
                'luastanah' => '150',
                'luasbangunan' => '100',
                'listrik' => '2200',
                'tahundibangun' => '2015',
                'fotoobjek' => 'foto1.jpg',
                'sertifikat' => 'sertifikat1.pdf',
                'sppt' => 'sppt1.pdf',
                'bidang' => 'A1',
                'distributed_to' => null,
                'status' => 'waiting',
                'note' => null,
                'approve_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'submission_name' => 'Pengajuan Verlok 2',
                'email' => 'user2@example.com',
                'nohp' => '089876543210',
                'namappat' => 'PPAT Andini',
                'nosertifikat' => '456/XYZ/2022',
                'latitude' => '-6.914744',
                'longitude' => '107.609810',
                'luastanah' => '200',
                'luasbangunan' => '150',
                'listrik' => '3500',
                'tahundibangun' => '2010',
                'fotoobjek' => 'foto2.jpg',
                'sertifikat' => 'sertifikat2.pdf',
                'sppt' => 'sppt2.pdf',
                'bidang' => 'B2',
                'distributed_to' => null,
                'status' => 'waiting',
                'note' => null,
                'approve_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
