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
        Schema::create('requests', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string("name");
            $table->integer("amount_request");
            $table->integer("amount_received")->nullable();
            $table->integer('amount_deliver');
            $table->timestamp("time_request")->useCurrent();
            $table->timestamp("time_accepted")->nullable();
            $table->string("amount_status");
            $table->boolean('deliver_status');
            $table->string('location');
            $table->integer("code");
            $table->boolean('edit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
