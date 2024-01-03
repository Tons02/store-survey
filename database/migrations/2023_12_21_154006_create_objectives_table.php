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
        Schema::create('objectives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('objective');
            $table->unsignedInteger('location_id');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        
            $table->foreign('location_id')->references('sync_id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objectives');
    }
};
