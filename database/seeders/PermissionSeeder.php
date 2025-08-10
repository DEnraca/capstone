<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Define the resource name

        // 1: "super_admin", 2: "chief_med_tech", 3: "patient", 4:"cashier", 6:"med_tech", 7: "admission_staff"
        $resources = collect([
            [
                'name' => 'Employee',
                'authorized_roles' => $this->getPermittedRole([1,2])
            ],
            [
                'name' => 'Service',
                'authorized_roles' => $this->getPermittedRole([1,2])
            ],
            [
                'name' => 'Appointment',
                'authorized_roles' => $this->getPermittedRole([1,2,6,7])
            ],
            [
                'name' => 'Station',
                'authorized_roles' => $this->getPermittedRole([1,2])
            ],
            [
                'name' => 'Department',
                'authorized_roles' => $this->getPermittedRole([1,2])
            ],
            [
                'name' => 'User',
                'authorized_roles' => $this->getPermittedRole([1,2])
            ],
            [
                'name' => 'Role',
                'authorized_roles' => $this->getPermittedRole([1])
            ],
            [
                'name' => 'Exception',
                'authorized_roles' => $this->getPermittedRole([1])
            ],
            [
                'name' => 'Activity',
                'authorized_roles' => $this->getPermittedRole([1])
            ]]
        );

        foreach ($resources as $resource){
            foreach($resource['authorized_roles'] as $role_name){
                $role = Role::where('name',$role_name)->first();
                if($role){
                    $permissions = Permission::where('name', 'like', '%'.strtolower($resource['name']).'%')->get()->pluck('name');
                    $role->givePermissionTo($permissions);
                }
            }
        }
    }

    public function getPermittedRole($role_ids){
        foreach($role_ids as $id){
            switch ($id) {
                case 1:
                    $roles[] = "super_admin";
                    break;
                case 2:
                    $roles[] = "chief_med_tech";
                    break;
                case 3:
                    $roles[] = "patient";
                    break;
                case 4:
                    $roles[] = "cashier";
                    break;
                case 6:
                    $roles[] = "med_tech";
                    break;
                case 7:
                    $roles[] = "admission_staff";
                    break;
            }
        }
        return $roles;
    }
}
