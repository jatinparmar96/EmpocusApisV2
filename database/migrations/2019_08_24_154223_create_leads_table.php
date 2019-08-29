<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id')->references('id')->on('companies');

            // Required Fields for lead Generation
            $table->string('company_name');
            $table->enum('lead_status', ['new', 'contacted', 'interested', 'under_review', 'demo', 'unqualified']);
            $table->enum('source', ['web', 'organic', 'email']);

            // Foreign Keys
            $table->integer('assigned_to')->references('id')->on('employees');
            $table->integer('product')->references('id')->on('products');

            // Nullable Fields
            $table->json('company_info')->nullable();
            $table->json('social')->nullable();
            $table->json('deal')->nullable();
            $table->json('source_info')->nullable();
            $table->timestamps();

            $table->integer('created_by')->references('id')->on('users');
            $table->integer('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
