<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['FrontEnd', 'Backend', 'Programming', 'Full stack', 'Design', 'Ops'];

        foreach ($types as $type_name) {
            $type = new Type();
            $type->name = $type_name;
            $type->slug = Str::slug($type_name);

            $type->save();
        }
    }
}
