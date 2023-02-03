<?php

use App\Enums\ActiveStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('sku')->index();
            $table->string('name')->index();
            $table->longText('description')->nullable();
            $table->double('stock_price')->nullable();
            $table->double('price')->nullable();
            $table->integer('stock')->nullable();
            $table->unsignedTinyInteger('status')->default(ActiveStatus::DISABLED());
            $table->json('images')->default(serialize([]));
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
        Schema::dropIfExists('product_variants');
    }
};
