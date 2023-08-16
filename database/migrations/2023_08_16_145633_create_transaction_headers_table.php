<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_headers', function (Blueprint $table) {
            $table->id();
            $table->string('id_user');
            $table->string('no_transaction');
            $table->integer('qty');
            $table->decimal('sub_total',13,2);
            $table->string('ref_code');
            $table->decimal('discount',13,2);
            $table->decimal('tax',13,2);
            $table->decimal('platform_fee',13,2);
            $table->decimal('grand_total',13,2);
            $table->decimal('partner_portion',13,2);
            $table->string('status');
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
        Schema::dropIfExists('transaction_headers');
    }
}
