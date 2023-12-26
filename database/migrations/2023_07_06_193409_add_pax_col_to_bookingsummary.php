<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaxColToBookingsummary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookingsummaryvendors', function (Blueprint $table) {
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
        Schema::table('bookingsummaryvendors', function (Blueprint $table) {
            $table->removeColumn("pax");
        });
    }
}
