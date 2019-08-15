<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_id');
            $table->string('project_title');
            $table->string('profile_id');
            $table->string('profile_name');
            $table->longText('comment');
            $table->enum('status', ['wrote on linkedin' , 'refused' , 'interested', 'rejected', 'shortlisted' , 'hired' , 'black_list'])->nullable()->default('wrote on linkedin');
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
        Schema::dropIfExists('comments');
    }
}
