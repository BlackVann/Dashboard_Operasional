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
        Schema::create('history__gudangs', function (Blueprint $table) {
            $table->id();
            $table->string('produk');
            $table->timestamp("date")->nullable();
            $table->string('code')->nullable();
            $table->integer('in')->nullable();
            $table->integer('out')->nullable();
            $table->integer('last_item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history__gudangs');
    }
};
