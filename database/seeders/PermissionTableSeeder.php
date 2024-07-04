<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            "user",
            "users-list",
            "update-user",
            "delete-user",
            "add-user",
            "about",
            "about-list",
            "update-about",
            "delete-about",
            "add-about",
            "role",
            "roles-list",
            "update-role",
            "delete-role",
            "add-role",


            "privacy",
            "privacy-list",
            "update-privacy",
            "delete-privacy",
            "add-privacy",

            "setting",
            "update-or-create-setting",
            "term",
            "term-list",
            "update-term",
            "delete-term",
            "add-term",

            "contact-us",

            "coupons",
            "coupons-create",
            "coupons-update",
            "discounts",
            "discounts-update",
            "questions",
            "questions-create",
            "questions-update",
            "questions-delete",
            "admin-dashboard",
            "coupons-delete",








        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
