<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_payment', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->foreignId("order_id");
            $table->integer("amount");
            $table->longText("bank_first_response");
            $table->longText("bank_second_response");
            $table->integer("transaction_id");
            $table->integer("gateway");
            $table->integer("status");
            $table->softDeletes();
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
        Schema::dropIfExists('online_payment');
    }
};
