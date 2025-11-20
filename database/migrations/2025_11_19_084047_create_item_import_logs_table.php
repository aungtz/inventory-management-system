<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('item_import_logs', function (Blueprint $table) {
            $table->id('ImportLog_ID');
            $table->tinyInteger('Import_Type')->comment('1 = Items, 2 = SKUs');
            $table->integer('Record_Count')->default(0);
            $table->integer('Error_Count')->default(0);
            $table->unsignedBigInteger('Imported_By');
            $table->timestamp('Imported_Date')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_import_logs');
    }
};
