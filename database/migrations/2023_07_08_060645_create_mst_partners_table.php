<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_partners', function (Blueprint $table) {
            $table->id();
            $table->string('partner_name')->nullable;
            $table->string('pic_name')->nullable;
            $table->string('pic_contact')->nullable;
            $table->string('contact_1')->nullable;
            $table->string('contact_2')->nullable;
            $table->text('partner_addr')->nullable;
            $table->string('province')->nullable;
            $table->string('city')->nullable;
            $table->string('district')->nullable;
            $table->string('sub_district')->nullable;
            $table->string('zip_code')->nullable;
            $table->string('is_active')->nullable;
            $table->string('npwp')->nullable;
            $table->string('created_by')->nullable;
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
        Schema::dropIfExists('mst_partners');
    }
}
