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
        Schema::table('local_impressoras', function (Blueprint $table) {
            $table->dropForeign('local_impressoras_produto_id_foreign');
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');

            $table->dropForeign('local_impressoras_diretoria_id_foreign');
            $table->foreign('diretoria_id')->references('id')->on('diretorias')->onDelete('cascade');

            $table->dropForeign('local_impressoras_divisao_id_foreign');
            $table->foreign('divisao_id')->references('id')->on('divisoes')->onDelete('cascade');
        });

        Schema::table('suprimentos', function (Blueprint $table) {
            $table->dropForeign('suprimentos_suprimento_id_foreign');
            $table->foreign('suprimento_id')->references('id')->on('produtos')->onDelete('cascade');

            $table->dropForeign('suprimentos_produto_id_foreign');
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
        });

        Schema::table('divisoes', function (Blueprint $table) {
            $table->dropForeign('divisoes_diretoria_id_foreign');
            $table->foreign('diretoria_id')->references('id')->on('diretorias')->onDelete('cascade');
        });

        Schema::table('diretorias', function (Blueprint $table) {
            $table->dropForeign('diretorias_orgao_id_foreign');
            $table->foreign('orgao_id')->references('id')->on('orgaos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
