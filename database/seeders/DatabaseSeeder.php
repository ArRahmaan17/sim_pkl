<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(50)->create();
        // Menu::factory()->create([
        //     [
        //         "name" => "Home",
        //         "icon" => "fas fa-home",
        //         "link" => "home",
        //         "parent" => 0,
        //         "position" => "S",
        //         "ordered" => null,
        //         "access_to" => "All",
        //         "created_at" => now('Asia/Jakarta'),
        //         "updated_at" => null
        //     ],
        //     [
        //         "name" => "Master",
        //         "icon" => "fas fa-database",
        //         "link" => "master",
        //         "parent" => 0,
        //         "position" => "S",
        //         "ordered" => null,
        //         "access_to" => "M",
        //         "created_at" => now('Asia/Jakarta'),
        //         "updated_at" => null
        //     ],
        //     [
        //         "name" => "Menu",
        //         "icon" => "fas fa-bars",
        //         "link" => "master.menus",
        //         "parent" => 2,
        //         "position" => "S",
        //         "ordered" => null,
        //         "access_to" => "M",
        //         "created_at" => now('Asia/Jakarta'),
        //         "updated_at" => null
        //     ],
        //     [
        //         "name" => "Profile",
        //         "icon" => "fas fa-profile",
        //         "link" => "user.profile",
        //         "parent" => 0,
        //         "position" => "N",
        //         "ordered" => null,
        //         "access_to" => "All",
        //         "created_at" => now('Asia/Jakarta'),
        //         "updated_at" => null
        //     ],
        //     [
        //         "name" => "Attendance",
        //         "icon" => "fas fa-fingerprint",
        //         "link" => "user.attendance",
        //         "parent" => 6,
        //         "position" => "S",
        //         "ordered" => null,
        //         "access_to" => "All",
        //         "created_at" => now('Asia/Jakarta'),
        //         "updated_at" => null
        //     ],
        //     [
        //         "name" => "User",
        //         "icon" => "fas fa-user",
        //         "link" => "user.attendance",
        //         "parent" => 0,
        //         "position" => "S",
        //         "ordered" => null,
        //         "access_to" => "All",
        //         "created_at" => "2023-10-23T09:41:41.000Z",
        //         "updated_at" => null
        //     ],
        //     [
        //         "name" => "Calendar",
        //         "icon" => "fas fa-list",
        //         "link" => "user.attendance.calendar",
        //         "parent" => 6,
        //         "position" => "S",
        //         "ordered" => null,
        //         "access_to" => "All",
        //         "created_at" => now('Asia/Jakarta'),
        //         "updated_at" => null
        //     ]
        // ]);
        // \App\Models\Task::factory(53)->create();
    }
}
