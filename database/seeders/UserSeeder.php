<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Meter;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name', 'admin')->first();

        $adminAccount = new Account();
        $adminAccount->account_num = 1234567890;
        $adminAccount->save();

        $admin = new User();
        $admin->first_name = 'John';
        $admin->last_name = 'Doe';
        $admin->email = 'johndoe@example.com';
        $admin->password = 'secret';
        $admin->role_id = $adminRole->id;
        $admin->account_id = $adminAccount->id;
        $admin->remember_token = Str::random(10);
        $admin->email_verified_at = now();
        $admin->save();

        $meters = new Meter();
        $meters->previous = 5521232;
        $meters->last = 5621232;
        $meters->account_id = $adminAccount->id;
        $meters->save();

    }
}
