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
        Schema::create('itens_produtos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_id');
            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->unsignedBigInteger('produto_vinculado_id');
            $table->foreign('produto_vinculado_id')->references('id')->on('produtos');
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
        Schema::table('itens_produtos', function (Blueprint $table) {
            $table->dropForeign('itens_produtos_produto_id_foreign');
            $table->dropColumn('produto_id');
            $table->dropForeign('itens_produtos_produto_vinculado_id_foreign');
            $table->dropColumn('produto_vinculado_id');
        });
        Schema::dropIfExists('itens_produtos');
    }
};