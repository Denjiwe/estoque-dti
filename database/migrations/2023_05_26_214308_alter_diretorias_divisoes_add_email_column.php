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
        Schema::table('diretorias', function (Blueprint $table) {
            $table->string('email', 100)->nullable();
        });

        Schema::table('divisoes', function (Blueprint $table) {
            $table->string('email', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('divisoes', function (Blueprint $table) {
            $table->dropColumn('email');
        });

        Schema::table('diretorias', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};
