<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        User::create([
            'name' => "Nawfal",
            'email' => "nawfal@gmail.com",
            'password' => bcrypt("password"),
            'is_admin' => 1,
        ]);

        User::create([
            'name' => "Ahmed",
            'email' => "ahmed@gmail.com",
            'password' => bcrypt("password"),
            'group' => "G-A",
            'is_admin' => 0,
        ]);
    }
}
