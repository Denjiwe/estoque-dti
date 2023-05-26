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
        Schema::create('suprimentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_id');
            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->unsignedBigInteger('suprimento_id');
            $table->foreign('suprimento_id')->references('id')->on('produtos');
            $table->enum('em_uso', ['SIM', 'NAO'])->default('NAO');
            $table->enum('tipo_suprimento', ['CILINDRO', 'IMPRESSORA']);
            $table->unique(['produto_id', 'suprimento_id'], 'unique_produto_suprimento_constraint');
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
        Schema::table('suprimentos', function (Blueprint $table) {
            $table->dropUnique('unique_produto_suprimento_constraint');
            $table->dropForeign('suprimentos_produto_id_foreign');
            $table->dropColumn('produto_id');
            $table->dropForeign('suprimentos_suprimento_id_foreign');
            $table->dropColumn('suprimento_id');
        });
        Schema::dropIfExists('suprimentos');
    }
};
