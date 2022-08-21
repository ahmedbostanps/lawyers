<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractSidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_sides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->index();
            $table->integer('contract_id')->index();
            $table->tinyInteger('type');

            $table->timestamps();
//            $table->foreign('client_id')->references('id')->on('advocate_clients')->onDelete('cascade');
//            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_sides');
    }
}
