<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->unique()->nullable();
            $table->string('title');
            $table->string('description')->nullable();
            $table->foreignId('author_id')->nullable()->constrained()->onDelete('set null');
            $table->string('cover')->nullable()->default('img/default_book.png');
            $table->integer('published_year')->nullable();
            $table->string('genre')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('books');
    }
};
