<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Role::truncate();

        Schema::enableForeignKeyConstraints();

        Role::insert([
            [
                "name" => "Admin",
                "guard_name" => "web",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => "Tukang",
                "guard_name" => "web",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => "User",
                "guard_name" => "web",
                "created_at" => now(),
                "updated_at" => now()
            ],
        ]);
    }
}
