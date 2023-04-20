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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 45);
            $table->enum('status', ['ATIVO', 'INATIVO']);
            $table->bigInteger('cpf')->unique;
            $table->string('email', 50)->unique;
            $table->string('senha', 16);

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
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropForeign('usuarios_divisao_id_foreign');
            $table->dropColumn('divisao_id');
            $table->dropForeign('usuarios_diretoria_id_foreign');
            $table->dropColumn('diretoria_id');
        });
        Schema::dropIfExists('usuarios');
    }
};
