<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shared_lists', function (Blueprint $table) {
            $table->id();

            $table->foreignId('owner_id')
                ->index()
                ->constrained('users');

            $table->foreignId('guest_id')
                ->index()
                ->constrained('users');

            $table->foreignId('list_id')
                ->index()
                ->constrained('todo_lists');

            $table->smallInteger('permission_level')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shared_lists');
    }
};
