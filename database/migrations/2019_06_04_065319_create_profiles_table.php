<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * 
     *
     * @return void
     */

    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->string('position');
            $table->string('profile');
            $table->string('portfolio')->nullable();      
            $table->enum('english', ['good' , 'fluent' , 'no english'])->default('good');
            $table->string('salary');
            $table->enum('source', ['linkedin' , 'refference' , 'job post'])->default('linkedin');
            $table->enum('status', ['wrote on linkedin' , 'refused' , 'interested', 'rejected', 'shortlisted' , 'hired' , 'black_list'])->default('wrote on linkedin');
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
        Schema::dropIfExists('profiles');
    }
}
