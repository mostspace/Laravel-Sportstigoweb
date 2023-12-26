<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsermanagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usermanages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('original_password');
            // $table->integer('role',11)->unsigned()->nullable()->comment('Admin = 0,Customer = 1,Other = 2,Vendor = 3,Instructor = 4,Host = 5');
            // $table->integer('status',11)->unsigned()->nullable()->comment('Active = 1, Inactive = 0');
            $table->timestamps();
        });

        Schema::create('userdetailmanages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            // $table->integer('role',11)->unsigned()->nullable()->comment('Admin = 0,Customer = 1,Other = 2,Vendor = 3,Instructor = 4,Host = 5');
            // $table->integer('status',11)->unsigned()->nullable()->comment('Active = 1, Inactive = 0');
            $table->timestamps();
        });

    }

    // Ex. $table->unsignedInteger('minimum_onsite_length')->default(180)->nullable()->comment('This is comment');

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usermanages');
        Schema::dropIfExists('userdetailmanages');        
    }
}
