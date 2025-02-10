<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Log;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()->setLocale("el");

        $this->command->info('Searching for user with email admin@test.com');
        $user = User::whereEmail("admin@test.com")->first();
        if($user){
            $this->command->info("User found {$user->name}");
        }else{
            $this->command->info("User not found");
            return;
        }
        $role = Role::where("name->en","Admin")->first();

        if($role){
            $this->command->info("Role found {$role->name}");
        }else{
            $this->command->info('Role not found');
            return;
        }

        $this->command->info('Attaching role to user');
        $user->roles()->attach($role->id);
    }
}
