<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRawProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raw_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('product_name');
            $table->string('product_display_name')->nullable();
            $table->string('product_code')->nullable();
            $table->integer('product_uom')->nullable();
            $table->integer('product_category')->nullable();
            $table->string('product_trade_name')->nullable();
            $table->integer('product_conv_uom')->nullable();
            $table->double('product_conv_factor', 8, 2)->nullable();
            $table->boolean('product_batch_type');
            $table->boolean('product_stock_ledger');
            $table->string('product_store_location')->nullable();
            $table->integer('product_opening_stock')->nullable();
            $table->double('opening_amount', 8, 2)->nullable();
            $table->string('product_rate_pick')->nullable();
            $table->double('product_purchase_rate', 8, 2)->nullable();
            $table->double('product_mrp_rate', 8, 2)->nullable();
            $table->double('product_sales_rate', 8, 2)->nullable();
            $table->double('product_gst_rate')->nullable();
            $table->integer('product_max_level')->nullable();
            $table->integer('product_min_level')->nullable();
            $table->integer('product_reorder_level')->nullable();
            $table->string('product_hsn')->nullable();

            $table->string('product_type')->nullable();

            $table->text('product_description')->nullable();
            $table->timestamps();

            $table->integer('created_by_id');
            $table->integer('updated_by_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raw_products');
    }
}
