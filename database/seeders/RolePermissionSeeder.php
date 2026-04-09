<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cache ક્લિયર કરવું જરૂરી છે
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ડોક્યુમેન્ટ મુજબના તમામ મોડ્યુલ્સ [cite: 91, 97, 100, 138]
        $modules = [
            'users',
            'stores',
            'products',
            'categories',
            'subcategories',
            'brands',
            'managers',
            'orders',
            'reports',
            'loyalty',
            'notifications',
            'inventory',
            'pos'
        ];

        $actions = ['view', 'create', 'edit', 'delete', 'manage'];

        // તમામ પરમિશન્સ ક્રિએટ કરવી
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "$action $module"]);
            }
        }

        // 1. Super Admin: બધી જ પરમિશન્સ [cite: 22, 23]
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdminRole->syncPermissions(Permission::all());

        // 2. Admin: યુઝર મેનેજમેન્ટ (S.Admin સિવાય), પ્રોડક્ટ્સ અને લોયલ્ટી કંટ્રોલ [cite: 33, 34, 38]
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->syncPermissions(Permission::whereIn('name', [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view stores',
            'view products',
            'create products',
            'edit products',
            'delete products',
            'view categories',
            'create categories',
            'edit categories',
            'view subcategories',
            'create subcategories',
            'edit subcategories',
            'view brands',
            'create brands',
            'edit brands',
            'delete brands',
            'view managers',
            'create managers',
            'edit managers',
            'delete managers',
            'view orders',
            'edit orders',
            'manage orders',
            'view reports',
            'manage loyalty',
            'manage notifications',
            'view inventory',
            'view pos',
            'create pos',
            'edit pos',
            'delete pos'
        ])->get());

        $storeManagerRole = Role::firstOrCreate(['name' => 'Store Manager']);
        $storeManagerRole->syncPermissions(Permission::whereIn('name', [
            'view users',
            'create users',
            'edit users',
            'view products',
            'create products',
            'edit products',
            'view brands',
            'create brands',
            'edit brands',
            'view categories',
            'view subcategories',
            'view inventory',
            'view loyalty',
            'view reports',
            'manage notifications',
            'view pos',
            'create pos',
        ])->get());

        $employeeRole = Role::firstOrCreate(['name' => 'Employee POS']);
        $employeeRole->syncPermissions(Permission::whereIn('name', [
            'create orders',
            'view orders',
            'view loyalty',
            'view pos',
        ])->get());

        $customerRole = Role::firstOrCreate(['name' => 'Customer']);
        $customerRole->syncPermissions(Permission::whereIn('name', [
            'view products',
            'view categories',
            'create orders',
            'view loyalty'
        ])->get());
    }
}
