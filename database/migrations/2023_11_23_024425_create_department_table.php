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
        Schema::create('departments', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedInteger('sync_id')->unique();
            $table->string('code')->index();
            $table->string('name');
            $table->unsignedInteger("company_sync_id")->index();
            $table->boolean('is_active')->default(true);
            $table->foreign("company_sync_id")
            ->references("sync_id")
            ->on("companies")
            ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department');
    }
};
