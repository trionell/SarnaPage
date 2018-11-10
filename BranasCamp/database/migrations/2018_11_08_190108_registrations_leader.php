<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RegistrationsLeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations_leader', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthdate');
            $table->string('last_four');
            $table->string('address');
            $table->string('zip');
            $table->string('city');
            $table->string('email');
            $table->string('phonenumber');
            $table->string('allergy');
            $table->string('first_name_advocate');
            $table->string('last_name_advocate');
            $table->string('email_advocate');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number_advocate');
            $table->string('home_number');
            $table->int('place');
            $table->boolean('member');
            $table->int('member_place');
            $table->boolean('kitchen');
            $table->tiemstamp('register_time');
            $table->int('cost');
            $table->string('other');
            $table->boolean('terms');
            $table->string('verification_key');
            $table->timestamp('verified_at');
            $table->string('verification_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblregistrations_leader');
    }
}
