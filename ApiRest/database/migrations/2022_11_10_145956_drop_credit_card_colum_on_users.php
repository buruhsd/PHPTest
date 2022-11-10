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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('creditcard_type');
            $table->dropColumn('creditcard_number');
            $table->dropColumn('creditcard_name');
            $table->dropColumn('creditcard_expired');
            $table->dropColumn('creditcard_cvv');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('creditcard_type');
            $table->string('creditcard_number');
            $table->string('creditcard_name');
            $table->string('creditcard_expired');
            $table->string('creditcard_cvv');
        });
    }
};
