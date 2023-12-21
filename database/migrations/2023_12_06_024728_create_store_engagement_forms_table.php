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
        Schema::create('store_engagement_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('contact');
            $table->string('store_name');
            $table->string('leader');
            $table->json('objectives');
            $table->json('strategies');
            $table->json('activities');
            $table->text('findings');
            $table->json('notes');
            $table->string('e_signature');
            $table->boolean('is_update');
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_engagement_forms');
    }
};
