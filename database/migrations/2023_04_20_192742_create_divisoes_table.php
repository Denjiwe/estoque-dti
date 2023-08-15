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
        Schema::create('divisoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 45);
            $table->enum('status', ['ATIVO', 'INATIVO']);
            $table->unsignedBigInteger('diretoria_id');
            $table->foreign('diretoria_id')->references('id')->on('diretorias');
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
        Schema::table('divisoes', function (Blueprint $table) {
            $table->dropForeign('divisoes_diretoria_id_foreign');
            $table->dropColumn('diretoria_id');
        });
        Schema::dropIfExists('divisoes');
    }
};
