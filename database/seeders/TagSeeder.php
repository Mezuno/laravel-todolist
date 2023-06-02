<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $recordCount = 100;

        for ($i = 0; $i < $recordCount; $i++) {
            $data[] = [
                'title' => Str::title(fake()->word()),
                'owner_id' => User::get('id')->random()->id,
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            Tag::insert($chunk);
        }
    }
}
