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
        $userRole = Role::where('name', 'user')->first();

        $userAccount = new Account();
        $userAccount->account_num = 5553399;
        $userAccount->save();

        $user1Account = new Account();
        $user1Account->account_num = 4443366;
        $user1Account->save();

        $adminAccount = new Account();
        $adminAccount->account_num = 1234567890;
        $adminAccount->save();

        $admin = new User();
        $admin->first_name = 'Admin';
        $admin->last_name = 'Admin';
        $admin->email = 'admin@example.com';
        $admin->password = 'secret';
        $admin->role_id = $adminRole->id;
        $admin->account_id = $adminAccount->id;
        $admin->remember_token = Str::random(10);
        $admin->email_verified_at = now();
        $admin->save();

        // abonent #1
        $user = new User();
        $user->first_name = 'Alexander';
        $user->last_name = 'Ivanov';
        $user->email = 'ivanov@example.com';
        $user->password = 'secret';
        $user->role_id = $userRole->id;
        $user->account_id = $userAccount->id;
        $user->remember_token = Str::random(10);
        $user->email_verified_at = now();
        $user->save();


        $meters = new Meter();
        $meters->previous = 100;
        $meters->last = 200;
        $meters->account_id = $userAccount->id;
        $meters->save();

        $meters = new Meter();
        $meters->previous = 200;
        $meters->last = 300;
        $meters->account_id = $userAccount->id;
        $meters->save();

        $bill = new Bill();
        $bill->account_id = $userAccount->id;
        $bill->bill_number = 1;
        $bill->amount = 500;
        $bill->save();

        // abonent #2
        $user = new User();
        $user->first_name = 'Viktor';
        $user->last_name = 'Vasiliev';
        $user->email = 'vasiliev@example.com';
        $user->password = 'secret';
        $user->role_id = $userRole->id;
        $user->account_id = $user1Account->id;
        $user->remember_token = Str::random(10);
        $user->email_verified_at = now();
        $user->save();


        $meters = new Meter();
        $meters->previous = 110;
        $meters->last = 280;
        $meters->account_id = $user1Account->id;
        $meters->save();

        $meters = new Meter();
        $meters->previous = 280;
        $meters->last = 499;
        $meters->account_id = $user1Account->id;
        $meters->save();

        $bill = new Bill();
        $bill->account_id = $user1Account->id;
        $bill->bill_number = 1;
        $bill->amount = 300;
        $bill->save();

    }
}
