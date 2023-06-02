<?php

namespace Database\Seeders;

use App\Models\ListItem;
use App\Models\TodoList;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ListItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $recordCount = 1280;

        for ($i = 0; $i < $recordCount; $i++) {
            $data[] = [
                'title' => Str::title(fake()->word()),
                'description' => fake()->text(70),
                'checked' => rand(0, 1),
                'preview_image' => null,
                'todo_list_id' => TodoList::get('id')->random()->id,
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            ListItem::insert($chunk);
        }
    }
}
