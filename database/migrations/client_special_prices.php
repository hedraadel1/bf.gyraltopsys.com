<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_special_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('from_country_id');
            $table->unsignedBigInteger('from_state_id');
            $table->unsignedBigInteger('from_area_id');
            $table->unsignedBigInteger('to_country_id');
            $table->unsignedBigInteger('to_state_id');
            $table->unsignedBigInteger('to_area_id');
            $table->decimal('shipping_cost', 8, 2);
            $table->decimal('return_cost', 8, 2);
            $table->decimal('tax', 8, 2)->nullable();
            $table->decimal('insurance', 8, 2)->nullable();
            $table->decimal('mile_cost', 8, 2);
            $table->decimal('return_mile_cost', 8, 2);
            $table->decimal('discount_percentage', 8, 2)->nullable();
            $table->decimal('discount_fixed_amount', 8, 2)->nullable();
            $table->timestamps();

            // Define foreign keys
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('from_country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('from_state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('from_area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->foreign('to_country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('to_state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('to_area_id')->references('id')->on('areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_special_prices');
    }
};