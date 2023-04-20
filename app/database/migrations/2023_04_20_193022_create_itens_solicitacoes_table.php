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
        Schema::create('itens_solicitacoes', function (Blueprint $table) {
            $table->id();
            $table->integer('qntde');
            $table->unsignedBigInteger('produto_id');
            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->unsignedBigInteger('solicitacao_id');
            $table->foreign('solicitacao_id')->references('id')->on('solicitacoes');
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
        Schema::table('itens_solicitacoes', function (Blueprint $table) {
            $table->dropForeign('itens_solicitacoes_produto_id_foreign');
            $table->dropColumn('produto_id');
            $table->dropForeign('itens_solicitacoes_solicitacao_id_foreign');
            $table->dropColumn('solicitacao_id');
        });
        Schema::dropIfExists('itens_solicitacaos');
    }
};
