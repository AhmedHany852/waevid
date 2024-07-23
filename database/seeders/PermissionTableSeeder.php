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
            "game-list",
            "create-game",
            "update-game",
            "delete-game",
            "social_media-list",
            "create-social_media",
            "update-social_media",
            "delete-social_media",
            "service-list",
            "create-service",
            "update-service",
            "delete-service",
            "user-list",
            "create-user",
            "update-user",
            "delete-user",
            "role-list",
            "create-role",
            "update-role",
            "delete-role",
            "contact-us-list",
            'setting',
            'update-setting',
            "term-list",
            'update-term',
            "privacy-list",
            'update-privacy',
            'about-us-list',
            'update-about-us',
            "all-payments",
            "game-report",
           "service-report",
           "social_media-report",
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
