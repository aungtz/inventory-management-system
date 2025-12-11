<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('item_import_data_logs', function (Blueprint $table) {
        $table->string('Item_Name')->nullable()->change();
        $table->string('MakerName')->nullable()->change();
        $table->string('Memo')->nullable()->change();
        $table->decimal('ListPrice', 10, 2)->nullable()->change();
        $table->decimal('SalePrice', 10, 2)->nullable()->change();
    });
}

public function down()
{
    Schema::table('item_import_data_logs', function (Blueprint $table) {
        $table->string('Item_Name')->nullable(false)->change();
        $table->string('MakerName')->nullable(false)->change();
        $table->string('Memo')->nullable(false)->change();
        $table->decimal('ListPrice', 10, 2)->nullable(false)->change();
        $table->decimal('SalePrice', 10, 2)->nullable(false)->change();
    });
}

};
