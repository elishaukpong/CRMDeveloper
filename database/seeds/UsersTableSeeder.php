<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = factory(User::class)->create([
            'email' => 'admin@test.test'
        ]);

        $adminUser->assignRole('Admin');
    }
}
