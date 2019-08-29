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
            $table->string('phone')->nullable();
            $table->string('position')->nullable();
            $table->string('profile')->nullable();
            $table->longText('comment')->nullable(); 
            $table->string('portfolio')->nullable();      
            $table->enum('english', ['good' , 'fluent' , 'no english'])->nullable()->default('good');
            $table->enum('feedback', ['not returned' , 'returned'])->nullable();
            $table->string('salary')->nullable();
            $table->string('net')->nullable();
            $table->enum('source', ['linkedin' , 'refference' , 'job post'])->nullable()->default('linkedin');
            $table->enum('status', ['wrote on linkedin' , 'refused' , 'interested', 'rejected', 'shortlisted' , 'hired' , 'black_list'])->nullable()->default('wrote on linkedin');
            $table->integer('author_id')->nullable()->default(1);
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
