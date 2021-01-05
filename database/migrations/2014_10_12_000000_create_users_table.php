<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('mobilenumber')->unique();
            $table->string('email_id')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('college_name');
            $table->integer('college_id_number');
            $table->string('profession');
            $table->date('dob');
            $table->string('active_status');
            $table->string('firebase_id')->nullable();
            $table->string('avatar')->nullable();
            $table->string('college_id_details')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
