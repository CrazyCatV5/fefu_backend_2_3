<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNews1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news1s', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->string('description', 255)->nullable();
            $table->mediumText('text');
            $table->boolean('is_published');
            $table->dateTime('published_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news1s');
    }
}
