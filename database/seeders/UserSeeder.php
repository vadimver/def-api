<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdmin();
        $this->createTestUsers();
    }

    protected function createAdmin()
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin_password'),
            'nickname' => 'Admin',
            'role' => UserRole::ADMIN->value,
        ]);
    }

    protected function createTestUsers()
    {
        User::factory(10)->create();
    }
}
