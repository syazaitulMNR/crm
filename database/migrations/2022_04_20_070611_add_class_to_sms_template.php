<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClassToSmsTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_template', function (Blueprint $table) {
            $table->string('class')->nullable()->after('user_id');
            $table->string('day')->nullable()->after('class');
            $table->string('hour')->nullable()->after('day');
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
            $table->dropColumn('class');
            $table->dropColumn('hour');
            $table->dropColumn('day');
        });
    }
}
