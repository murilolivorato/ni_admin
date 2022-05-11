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
        Schema::create('movimentacao', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->enum('tipo_movimentacao', ['entrada', 'saida'])->default('entrada');
            $table->decimal('valor', 8, 2);
            $table->string('observacao');
            $table->bigInteger('funcionario_id')->unsigned();
            $table->foreign('funcionario_id')->references('id')->on('funcionario');
            $table->bigInteger('administrador_id')->unsigned();
            $table->foreign('administrador_id')->references('id')->on('administrador');
            $table->date('data_criacao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimentacao', function(Blueprint $table){
            $table->dropForeign('prop_movimentacao_funcionario_id_foreign');
            $table->dropForeign('prop_movimentacao_administrador_id_foreign');
        });
        Schema::dropIfExists('movimentacao');
    }
};
