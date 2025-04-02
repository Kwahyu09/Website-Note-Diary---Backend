<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // roles
        $roles=[
            'admin',
            'staf',
            'pegawai'
        ];

        // setup permision
        $permissions=[
            'user' => ['get', 'register', 'get-by-id', 'update', 'delete', 'update-password'],
        ];

        $RolePermission=[
            'admin'=>[
                'user'=>'*',
            ],
            'staf'=>[
                'user'=>['get-by-id','update','update-password'],
            ],
            'pegawai'=>[
                'user'=>['get-by-id','update','register','update-password'],
            ]
        ];

        foreach($roles as $role){
            Role::create(['name' => $role]);
        }

        foreach($permissions as $permission => $type){
            foreach($type as $t){
                Permission::create(['name' => $permission.'.'.$t]);
            }
        }

        foreach($RolePermission as $r => $perms){
            $role = Role::findByName($r);
            foreach($perms as $perm => $p){
                if($perms[$perm] == '*'){
                    foreach($permissions[$perm] as $prm){
                        $role->givePermissionTo($perm.'.'.$prm);
                    }
                }else{
                    foreach($p as $prm){
                        $role->givePermissionTo($perm.'.'.$prm);
                    }
                }
            }
        }
    }
}
