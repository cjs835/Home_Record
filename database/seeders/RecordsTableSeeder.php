<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Record;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Record::truncate();
        $max = 2500;
        foreach (range(1, $max) as $number) {
            Record::create([
                               'temperature' => rand(0, 100),
                               'humidity' => rand(0, 100),
                               'time' => Carbon::now()->subHours(($max - $number)),
                           ]);
        }
    }
}
