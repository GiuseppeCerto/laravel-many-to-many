<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $techologies = ['CSS', 'SASS', 'HTML', 'JavaScript', 'Tailwind', 'PHP', 'Vue', 'SQL', 'NoSQL', 'MongoDB'];
    
            foreach ($techologies as $technology_name) {
                $technology = new Technology();
                $technology->name = $technology_name;
                $technology->slug = Str::slug($technology_name);
                $technology->save();
            }
        }
    }
}
