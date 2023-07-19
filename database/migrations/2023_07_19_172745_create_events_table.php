<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('id_partner');
            $table->string('event_category');
            $table->string('event_name');
            $table->string('highlight')->nullable;
            $table->text('description')->nullable;
            $table->text('event_address');
            $table->string('province');
            $table->string('city');
            $table->string('district');
            $table->string('sub_district');
            $table->string('zip_code');
            $table->longText('exchange_ticket_info');
            $table->longText('tc_info');
            $table->longText('including_info')->nullable;
            $table->longText('excluding_info')->nullable;
            $table->longText('facility')->nullable;
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->time('showtime_start');
            $table->time('showtime_end');
            $table->string('is_active');
            $table->string('created_by');
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
        Schema::dropIfExists('events');
    }
}
