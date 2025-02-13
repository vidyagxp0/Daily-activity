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
        $division->name = "IND ";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "Asia";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "Africa";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "Antractica";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "Australia";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "North America";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "South America";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "Europe";
        $division->status = 1;
        $division->save();
    }
}
