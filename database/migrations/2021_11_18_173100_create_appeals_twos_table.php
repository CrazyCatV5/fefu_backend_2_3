<?php

use App\Enums\Gender;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppealsTwosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appeals', function (Blueprint $table) {
            $table->string('surname', 40);
            $table->string('patronymic', 20)->nullable();
            $table->integer('age');
            $table->enum('gender', [Gender::MALE, Gender::FEMALE]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('appeals', ['surname', 'patronymic', 'age', 'gender']);
    }
}
