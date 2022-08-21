<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_terms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->index();
            $table->string('name');
            $table->timestamps();
//            $table->foreign('category_id')->references('id')->on('contract_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_terms');
    }
}
