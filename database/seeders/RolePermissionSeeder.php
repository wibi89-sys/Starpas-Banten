<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Define Roles based on requirements
        $roles = [
            'Super Admin',
            'Admin Pelayanan',
            'Pejabat Disposisi',
            'Admin Bidang',
            'Operator UPT',
            'Reviewer',
            'Pimpinan',
            'Publik'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create Default Users for each role to facilitate verification
        $defaultUsers = [
            'Super Admin' => 'superadmin@starpas.banten.go.id',
            'Admin Pelayanan' => 'admin.pelayanan@starpas.banten.go.id',
            'Pejabat Disposisi' => 'pejabat.disposisi@starpas.banten.go.id',
            'Admin Bidang' => 'admin.bidang@starpas.banten.go.id',
            'Operator UPT' => 'operator.upt@starpas.banten.go.id',
            'Reviewer' => 'reviewer@starpas.banten.go.id',
            'Pimpinan' => 'pimpinan@starpas.banten.go.id',
            'Publik' => 'publik@starpas.banten.go.id'
        ];

        foreach ($defaultUsers as $role => $email) {
            $user = User::firstOrCreate([
                'email' => $email
            ], [
                'name' => $role . ' User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            if (!$user->hasRole($role)) {
                $user->assignRole($role);
            }
        }
    }
}
