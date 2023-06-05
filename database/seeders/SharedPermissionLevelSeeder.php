<?php

namespace Database\Seeders;

use App\Models\SharedPermissionLevel;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SharedPermissionLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['title' => Str::title('Просматривать')],
            ['title' => Str::title('Выполнять задачи')],
            ['title' => Str::title('Редактировать')],
        ];

        SharedPermissionLevel::insert($data);
    }
}
