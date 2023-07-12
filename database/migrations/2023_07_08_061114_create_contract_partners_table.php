<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_partners', function (Blueprint $table) {
            $table->id();
            $table->string('id_partner')->nullable;
            $table->dateTime('start_date')->nullable;
            $table->dateTime('end_date')->nullable;
            $table->string('is_active')->nullable;
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
        Schema::dropIfExists('contract_partners');
    }
}
