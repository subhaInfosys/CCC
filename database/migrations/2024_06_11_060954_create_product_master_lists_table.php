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
        if (!Schema::hasTable('product_master_lists')) {
            Schema::create('product_master_lists', function (Blueprint $table) {
                $table->id('ProductID');
                $table->string('Types');
                $table->string('Brand');
                $table->string('Model');
                $table->string('Capacity');
                $table->integer('Quantity');
                $table->softDeletes(); // <-- This will add a deleted_at column in the table;
                $table->timestamps(); // <-- This will add a created_at and updated_at column in the table;
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('product_master_lists');
    }
};
