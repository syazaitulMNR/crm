<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnToSmsTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_template', function (Blueprint $table) {
            $table->dropColumn(['class', 'hour', 'day']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms_template', function (Blueprint $table) {
            $table->string('class')->nullable();
            $table->string('day')->nullable();
            $table->string('hour')->nullable();
        });
    }
}
