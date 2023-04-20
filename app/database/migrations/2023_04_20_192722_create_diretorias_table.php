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
        Schema::create('diretorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 45)->unique();
            $table->enum('status', ['ATIVO', 'INATIVO']);
            $table->unsignedBigInteger('orgao_id');
            $table->foreign('orgao_id')->references('id')->on('orgaos');
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
        Schema::table('diretorias', function (Blueprint $table) {
            $table->dropForeign('diretorias_orgao_id_foreign');
            $table->dropColumn('orgao_id');
        });
        Schema::dropIfExists('diretorias');
    }
};
