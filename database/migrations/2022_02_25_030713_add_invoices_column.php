<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoicesColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('product_features_id')->nullable()->after('student_id');
            $table->string('product_features_name')->nullable()->after('student_id');
            $table->string('taxable_amount')->nullable()->after('student_id');
            $table->string('tax')->nullable()->after('student_id');
            $table->string('quantity')->nullable()->after('student_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('product_features_id');
            $table->dropColumn('product_features_name');
            $table->dropColumn('taxable_amount');
            $table->dropColumn('tax');
            $table->dropColumn('quantity');
        });
    }
}
