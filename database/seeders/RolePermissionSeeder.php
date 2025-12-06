<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permission های بخش دسته‌بندی
        Permission::firstOrCreate(['name' => 'category.create']);
        Permission::firstOrCreate(['name' => 'category.read']);
        Permission::firstOrCreate(['name' => 'category.update']);
        Permission::firstOrCreate(['name' => 'category.delete']);

        // ساخت نقش ادمین
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        //برای تست گذاشتم فعلا role admin همه ی کارهای سمت داشبورد ادمین رو میتونه انجام بده
        //وقتی نقش های آشپز و ... اضافه شد پرمیشن ها بیشتر به کار میاد
        $adminPermission = [
            'category' => [
                'category.create',
                'category.read',
                'category.update',
                'category.delete',
            ]
        ];

        // دادن همه‌ی پرمیشن‌ها به ادمین
        $adminRole->givePermissionTo($adminPermission['category']);
    }
}
