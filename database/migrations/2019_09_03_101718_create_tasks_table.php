<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            /**
             * Task Main Fields
             */
            $table->enum('task_type',['calling','meeting','follow_up','send_quotation','order_generated']);
            $table->date('due_date');
            $table->text('description')->nullable();
            $table->integer('is_done');

            $table->integer('lead_id')->references('id')->on('leads');

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
        Schema::dropIfExists('tasks');
    }
}
