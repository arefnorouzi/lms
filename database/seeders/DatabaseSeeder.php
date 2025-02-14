<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $admin = User::factory()->create([
            'name' => 'عارف نوروزی',
            'nick_name' => 'ادمین',
            'username' => 'admin',
            'email' => 'info@caspiweb.ir',
            'password' => bcrypt('12345678'),
            'is_admin' => true,
            'mobile' => '09192138510',
            'mobile_verified' => true,
            'email_verified_at' => now(),
            'national_code' => '2670213359',
            'phone' => '01344305892',
            'bio' => 'برنامه نویس وب',
            'website' => 'https://caspiweb.ir',
            'work_mail' => 'arefnorouzi1374@gmail.com',
            'whatsapp' => 'https://wa.me/+989192138510',
            'instagram' => 'https://instagram.com/aref_norouzi_dev',
            'telegram' => 'https://t.me/caspiweb_ir',
        ]);



        User::factory()->count(78)->create();

        $this->call([
            RoleSeeder::class,
            ShippingMethodSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            CommentSeeder::class,


        ]);
        $admin_role = Role::where('name', 'admin')->first();
        $admin->roles()->attach($admin_role->id);
    }
}
