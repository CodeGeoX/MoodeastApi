<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmotionalCardsTable extends Migration
{
    public function up()
    {
        Schema::create('emotional_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('emotional_state');
            $table->json('emotions')->nullable(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('emotional_state_cards');
    }
}

