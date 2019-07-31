<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('start_date')->nullable();
            $table->text('end_date')->nullable();
            $table->longText('comment')->nullable();
            $table->string('referral')->nullable();
            $table->enum('status', ['planned' , 'in progress' , 'postponed' , 'cancelled' , 'arcguved'])->nullable()->nullable()->default('in progress');
            $table->integer('author_id')->default(1);
            $table->integer('updater_id')->default(1);
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
        Schema::dropIfExists('projects');
    }
}
