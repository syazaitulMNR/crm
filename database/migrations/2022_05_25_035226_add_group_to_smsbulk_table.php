<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupToSmsbulkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('smsbulk', function (Blueprint $table) {
            $table->string('type')->nullable()->after('id');
            $table->string('schedule_id')->nullable()->after('template_id');
            $table->string('group_id')->nullable()->after('schedule_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('smsbulk', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('schedule_id');
            $table->dropColumn('group_id');
        });
    }
}
