<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('contactable_id');
            $table->string('contactable_type');

            $table->string('name');
            $table->string('email')->nullable();;
            $table->string('designation')->nullable();;
            $table->string('primary_contact_number');
            $table->string('secondary_contact_number')->nullable();;

            $table->json('more_info')->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
