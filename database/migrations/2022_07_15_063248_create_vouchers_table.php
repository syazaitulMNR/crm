<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_id');
            $table->string('name');
            $table->string('desc')->nullable();
            $table->longText('tnc')->nullable();
            $table->string('start_date');
            $table->string('end_date');
            $table->string('product_id')->nullable();
            $table->string('package_id')->nullable();
            $table->integer('max')->nullable();
            $table->string('img_path')->nullable();
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
        Schema::dropIfExists('vouchers');
    }
}
