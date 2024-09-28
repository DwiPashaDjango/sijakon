<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Satuan;
use App\Models\SumberProyek;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call([
        //     RoleSeeder::class,
        //     UserSeeder::class,
        // ]);

        $satuan = [
            "Unit",
            "Pcs",
            "Buah",
            "M",
            "M2",
            "M3",
            "Kaleng",
            "Kg",
            "Ton",
            "Lembar",
            "Batang",
            "Lonjor",
            "Set",
            "Liter",
            "Sak",
            "Meter",
            "Keping",
            "Pack",
            "Dus",
            "Tangki",
            "Rool",
            "Karung",
            "Pasang",
            "Pasang",
            "Kotak",
        ];

        foreach ($satuan as $st) {
            Satuan::create(['name' => $st]);
        }

        $sumberProyek = [
            'Pemerintah',
            'Swasta',
            'APBN',
            'APBD',
        ];

        foreach ($sumberProyek as $sp) {
            SumberProyek::create(['name' => $sp]);
        }
    }
}
