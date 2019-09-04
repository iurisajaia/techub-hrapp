<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientPersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_person', function (Blueprint $table) {
            $table->bigIncrements('id')->nullable();
            $table->string('person_id')->nullable();
            $table->string('client_id')->nullable();
            $table->string('month_id')->nullable();
            $table->boolean('type')->nullable();
            $table->string('cost')->nullable();
            $table->string('rate')->nullable();
            $table->string('total')->nullable();
            $table->string('profit')->nullable();
            $table->string('percent')->nullable();
            $table->string('hours')->nullable();
            $table->string('salary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_person');
    }
}
