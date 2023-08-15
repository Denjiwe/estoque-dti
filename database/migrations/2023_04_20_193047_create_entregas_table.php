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
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->integer('qntde');
            $table->string('observacao', 255)->nullable();
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->unsignedBigInteger('itens_solicitacao_id');
            $table->foreign('itens_solicitacao_id')->references('id')->on('itens_solicitacoes');
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
        Schema::table('entregas', function (Blueprint $table) {
            $table->dropForeign('entregas_usuario_id_foreign');
            $table->dropColumn('usuario_id');
            $table->dropForeign('entregas_itens_solicitacao_id_foreign');
            $table->dropColumn('itens_solicitacao_id');
        });
        Schema::dropIfExists('entregas');
    }
};
