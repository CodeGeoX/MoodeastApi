<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFraseDiariasTable extends Migration
{
    public function up()
    {
        Schema::create('frase_diarias', function (Blueprint $table) {
            $table->id();
            $table->string('frase');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('frase_diarias');
    }
}
