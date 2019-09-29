<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('display_name')->nullable();
            $table->string('email')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('website')->nullable();
            $table->string('tan_number')->nullable();

            $table->string('iec_number')->nullable();
            $table->string('epc_number')->nullable();
            $table->string('ssi_number')->nullable();
            $table->string('nsic_number')->nullable();
            $table->string('udyog_aadhaar')->nullable();
            $table->string('tds_number')->nullable();
            $table->string('cin_number')->nullable();
            $table->string('gst_number')->nullable();
            $table->timestamps();

            $table->integer('created_by_id')->references('id')->on('users');
            $table->integer('updated_by_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
