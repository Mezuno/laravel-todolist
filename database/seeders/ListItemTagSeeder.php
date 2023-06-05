<?php

namespace Database\Seeders;

use App\Models\ListItem;
use App\Models\ListItemTag;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ListItemTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $recordCount = 80;

        for ($i = 0; $i < $recordCount; $i++) {
            $data[] = [
                'tag_id' => Tag::get('id')->random()->id,
                'list_item_id' => ListItem::get('id')->random()->id,
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            ListItemTag::insert($chunk);
        }
    }
}
