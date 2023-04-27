<?php

namespace Database\Seeders;

use App\Models\Technology;
use App\Models\Type;
use App\Models\Work;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $type_ids = Type::all()->pluck('id')->all();
        $technology_ids = Technology::all()->pluck('id')->all();

        for ($i = 0; $i < 50; $i++) {

            $work = new Work();
            $work->name = $faker->unique()->sentence($faker->numberBetween(1, 3));
            $work->client = $faker->sentence(2);
            $work->description = $faker->text(100);
            $work->slug = Str::slug($work->name, '-');
            $work->type_id = $faker->optional()->randomElement($type_ids);
            $work->save();

            $work->technology()->attach($faker->randomElements($technology_ids, rand(0, 5)));
        }
    }
}
