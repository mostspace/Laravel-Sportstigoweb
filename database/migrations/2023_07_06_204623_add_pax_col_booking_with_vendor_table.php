<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaxColBookingWithVendorTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_with_vendorsdetails', function (Blueprint $table) {
            $table->integer("pax")->after("price")->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_with_vendorsdetails', function (Blueprint $table) {
            $table->removeColumn("pax");
        });
    }
}
