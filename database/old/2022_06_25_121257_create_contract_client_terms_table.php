<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractClientTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_client_terms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_id')->index();
            $table->integer('term_category_id')->index();
            $table->integer('contract_term_id')->index();

            $table->timestamps();
//            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
//            $table->foreign('term_category_id')->references('id')->on('contract_categories')->onDelete('cascade');
//            $table->foreign('contract_term_id')->references('id')->on('contract_terms')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_client_terms');
    }
}
