<?php

namespace Database\Seeders;

use App\Models\SharedList;
use App\Models\SharedPermissionLevel;
use App\Models\Tag;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SharedListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $recordCount = 30;

        for ($i = 0; $i < $recordCount; $i++) {
            $ownerId = User::get('id')->random()->id;
            $listId = TodoList::where('owner_id', $ownerId)->get()->random()->id;
            $data[] = [
                'owner_id' => $ownerId,
                'guest_id' => User::where('id', '!=', $ownerId)->get()->random()->id,
                'list_id' => $listId,
                'permission_level' => SharedPermissionLevel::get('id')->random()->id,
                'updated_at' => now(),
                'created_at' => now(),
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            SharedList::insert($chunk);
        }
    }
}
