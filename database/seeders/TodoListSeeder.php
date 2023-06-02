<?php

namespace Database\Seeders;

use App\Models\TodoList;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
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
        $recordCount = 160;

        for ($i = 0; $i < $recordCount; $i++) {
            $data[] = [
                'title' => Str::title(fake()->word()),
                'description' => fake()->text(70),
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            TodoList::insert($chunk);
        }
    }
}
