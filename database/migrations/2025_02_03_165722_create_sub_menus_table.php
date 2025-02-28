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
    Schema::create('sub_menus', function (Blueprint $table) {
        $table->id();
        $table->string("name", 100);
        $table->unsignedBigInteger('main_menu_id');
        $table->foreign("main_menu_id")
              ->references("id")
              ->on("main_menus")
              ->cascadeOnUpdate()
              ->restrictOnDelete();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_menus');
    }
};
