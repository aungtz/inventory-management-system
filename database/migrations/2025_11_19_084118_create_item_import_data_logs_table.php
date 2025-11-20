<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('item_import_data_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ImportLog_ID');
            $table->string('Item_Code');
            $table->string('Item_Name');
            $table->string('JanCD', 13)->nullable();
            $table->string('MakerName')->nullable();
            $table->text('Memo')->nullable();
            $table->decimal('ListPrice', 12, 2)->nullable();
            $table->decimal('SalePrice', 12, 2)->nullable();
            $table->string('Size_Name')->nullable();
            $table->string('Color_Name')->nullable();
            $table->string('Size_Code')->nullable();
            $table->string('Color_Code')->nullable();
            $table->string('JanCode')->nullable();
            $table->integer('Quantity')->nullable();
            $table->timestamps();

            $table->foreign('ImportLog_ID')->references('ImportLog_ID')->on('item_import_logs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_import_data_logs');
    }
};
