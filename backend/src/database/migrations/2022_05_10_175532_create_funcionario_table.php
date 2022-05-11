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
        Schema::create('funcionario', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('administrador_id')->unsigned();
            $table->foreign('administrador_id')->references('id')->on('administrador');
            $table->string('login')->unique();
            $table->string('nome_completo');
            $table->decimal('saldo_atual', 8, 2);
            $table->date('data_criacao');
            $table->date('data_alteracao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prop_funcionario', function(Blueprint $table){
            $table->dropForeign('prop_funcionario_administrador_id_foreign');
        });
        Schema::dropIfExists('prop_funcionario');
    }
};
