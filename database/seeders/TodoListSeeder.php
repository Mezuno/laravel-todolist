<?php

namespace Database\Seeders;

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TodoListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $recordCount = 10;

        for ($i = 0; $i < $recordCount; $i++) {
            $data[] = [
                'title' => Str::title(fake()->word()),
                'description' => fake()->text(70),
                'owner_id' => User::get('id')->random()->id,
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            TodoList::insert($chunk);
        }
    }
}
