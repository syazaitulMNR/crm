<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_features', function (Blueprint $table) {
            $table->id();
            $table->string('product_features_name');
            $table->string('product_features_id');
            $table->string('features_price');
            $table->string('description_features');
            $table->string('features_tax');
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
        Schema::dropIfExists('product_features');
    }
}
