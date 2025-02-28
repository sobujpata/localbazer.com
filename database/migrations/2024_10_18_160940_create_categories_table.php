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
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id'); // Auto-increment primary key
            $table->string('categoryName', 50);
            $table->string('categoryImg', 300)->nullable();
            $table->unsignedBigInteger('main_category_id'); // No autoIncrement
            $table->timestamps();

            // Foreign key constraint (assuming you have a main_categories table)
            $table->foreign('main_category_id')->references('id')->on('main_categories')
                    ->restrictOnDelete()
                    ->cascadeOnUpdate();

           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
