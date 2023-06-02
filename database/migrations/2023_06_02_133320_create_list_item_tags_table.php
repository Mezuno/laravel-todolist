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
        Schema::create('list_item_tags', function (Blueprint $table) {
            $table->id();

            $table->foreignId('list_item_id')
                ->index()
                ->constrained('list_items');

            $table->foreignId('tag_id')
                ->index()
                ->constrained('tags');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_item_tags');
    }
};
