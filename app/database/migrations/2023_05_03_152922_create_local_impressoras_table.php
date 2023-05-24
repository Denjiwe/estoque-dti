<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_impressoras', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('produto_id');
            $table->foreign('produto_id')->references('id')->on('produtos');

            $table->unsignedBigInteger('diretoria_id')->nullable();
            $table->foreign('diretoria_id')->references('id')->on('diretorias');

            $table->unsignedBigInteger('divisao_id')->nullable();
            $table->foreign('divisao_id')->references('id')->on('divisoes');

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
        Schema::table('local_impressoras', function (Blueprint $table) {
            $table->dropForeign('local_impressoras_divisao_id_foreign');
            $table->dropColumn('divisao_id');

            $table->dropForeign('local_impressoras_diretoria_id_foreign');
            $table->dropColumn('diretoria_id');

            $table->dropForeign('local_impressoras_produto_id_foreign');
            $table->dropColumn('produto_id');
        });

        DB::statement(
            'DROP TRIGGER IF EXISTS `estoque_dti`.`delete_qntde_estoque`
            
            DROP TRIGGER IF EXISTS `estoque_dti`.`insert_qntde_estoque`'
        );

        Schema::dropIfExists('local_impressoras');
    }
};
