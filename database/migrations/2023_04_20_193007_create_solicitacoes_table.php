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
        Schema::create('solicitacoes', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['AGUARDANDO', 'ABERTO', 'ENCERRADO', 'LIBERADO']);
            $table->string('observacao', 255)->nullable();
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->unsignedBigInteger('divisao_id')->nullable();
            $table->foreign('divisao_id')->references('id')->on('divisoes');
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
        Schema::table('solicitacaos', function (Blueprint $table) {
            $table->dropForeign('solicitacoes_usuario_id_foreign');
            $table->dropColumn('usuario_id');
            $table->dropForeign('solicitacoes_divisao_id_foreign');
            $table->dropColumn('divisao_id');
            $table->dropForeign('solicitacoes_diretoria_id_foreign');
            $table->dropColumn('diretoria_id');
        });
        Schema::dropIfExists('solicitacaos');
    }
};
