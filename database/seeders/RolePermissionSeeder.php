<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Routing\RouteUri;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name'=>'tambah-user']);
        Permission::create(['name'=>'edit-user']);
        Permission::create(['name'=>'hapus-user']);
        Permission::create(['name'=>'lihat-user']);

        Permission::create(['name'=>'tambah-permohonan']);
        Permission::create(['name'=>'edit-permohonan']);
        Permission::create(['name'=>'hapus-permohonan']);
        Permission::create(['name'=>'lihat-permohonan']);

        Role::create(['name'=>'kasi']);
        Role::create(['name'=>'petugas']);
        Role::create(['name'=>'pelayanan']);
        Role::create(['name'=>'kabid']);

        $roleKasi = Role::findByName('kasi');
        $roleKasi->givePermissionTo('tambah-user');
        $roleKasi->givePermissionTo('edit-user');
        $roleKasi->givePermissionTo('hapus-user');
        $roleKasi->givePermissionTo('lihat-user');

        $rolePelayanan = Role::findByName('pelayanan');
        $rolePelayanan->givePermissionTo('tambah-permohonan');
        $rolePelayanan->givePermissionTo('edit-permohonan');
        $rolePelayanan->givePermissionTo('hapus-permohonan');
        $rolePelayanan->givePermissionTo('lihat-permohonan');

    }
}
