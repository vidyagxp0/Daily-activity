<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\QMSDivision;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $division = new QMSDivision();
        $division->name = "Analytical Research & Development";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "Reference Standard";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "Microbiology";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "Biologics";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "PvPI";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "Quality Assurance";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "MvPI";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "Others";
        $division->status = 1;
        $division->save();
    }
}
