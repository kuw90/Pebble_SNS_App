<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command->warn('ADMIN_EMAIL / ADMIN_PASSWORD が未設定のため、スキップしました');
            return;
        }

        $admin = User::updateOrCreate(
            ['email' => Str::lower($email)],
            ['name' => '管理者', 'password' => Hash::make($password)]
        );

        $role = Role::firstOrCreate(['name' => 'admin']);
        $admin->roles()->syncWithoutDetaching([$role->id]);
    }
}