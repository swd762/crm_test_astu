<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Bill;
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
        $meters->previous = 100;
        $meters->last = 200;
        $meters->account_id = $adminAccount->id;
        $meters->save();

        $meters = new Meter();
        $meters->previous = 200;
        $meters->last = 300;
        $meters->account_id = $adminAccount->id;
        $meters->save();

        $bill = new Bill();
        $bill->account_id = $adminAccount->id;
        $bill->bill_number = 1;
        $bill->amount = 500;
        $bill->save();

    }
}
