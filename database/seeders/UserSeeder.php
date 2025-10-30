<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password123'),
            'dept' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create test user
        User::create([
            'name' => 'PQD User',
            'email' => 'pqd@aii.com',
            'password' => Hash::make('password123'),
            'dept' => 'PQD',
            'email_verified_at' => now(),
        ]);

        // Create departmental users
        User::create([
            'name' => 'PPC User',
            'email' => 'ppc@aii.com',
            'password' => Hash::make('password123'),
            'dept' => 'PPC',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'GAF User',
            'email' => 'gaf@aii.com',
            'password' => Hash::make('password123'),
            'dept' => 'GAF',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'FIN User',
            'email' => 'fin@aii.com',
            'password' => Hash::make('password123'),
            'dept' => 'FIN',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'ACC User',
            'email' => 'acc@aii.com',
            'password' => Hash::make('password123'),
            'dept' => 'ACC',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'MIS User',
            'email' => 'mis@aii.com',
            'password' => Hash::make('password123'),
            'dept' => 'MIS',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'AEO User',
            'email' => 'aeo@aii.com',
            'password' => Hash::make('password123'),
            'dept' => 'AEO',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'QSA User',
            'email' => 'qsa@aii.com',
            'password' => Hash::make('password123'),
            'dept' => 'QSA',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'MSU User',
            'email' => 'msu@aii.com',
            'password' => Hash::make('password123'),
            'dept' => 'MIS',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'HRD User',
            'email' => 'hrd@aii.com',
            'password' => Hash::make('password123'),
            'dept' => 'HRD',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'MTE User',
            'email' => 'mte@aii.com',
            'password' => Hash::make('password123'),
            'dept' => 'MTE',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'Internal Audit User',
            'email' => 'internal_audit@aii.com',
            'password' => Hash::make('password123'),
            'dept' => 'internal_audit',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'Management 1 User',
            'email' => 'management1@aii.com',
            'password' => Hash::make('password123'),
            'dept' => 'management1',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'Management 2 User',
            'email' => 'management2@aii.com',
            'password' => Hash::make('password123'),
            'dept' => 'management2',
            'email_verified_at' => now(),
        ]);

    }
}
