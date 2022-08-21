<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractCategoriesAndTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('contract_categories_and_terms', function (Blueprint $table) {
//            $table->increments('id');
//            $table->unsignedInteger('category_id');
//            $table->unsignedInteger('term_id');
//            $table->unsignedInteger('contract_id');
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_categories_and_terms');
    }
}
