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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_prefix');
            $table->string('id_no');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->enum("sex", ["male", "female"]);
            $table->string('username')->unique();
            $table->string('password');
            $table->unsignedInteger('location_id');
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger("role_id")->index();
            $table->boolean('is_active')->default(true);


            $table->foreign('location_id')->references('sync_id')->on('locations')->onDelete('cascade');
            $table->foreign('department_id')->references('sync_id')->on('departments')->onDelete('cascade');
            $table->foreign('company_id')->references('sync_id')->on('companies')->onDelete('cascade');

            $table->foreign("role_id")
            ->references("id")
            ->on("role_management")
            ->onDelete('cascade');
            
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
