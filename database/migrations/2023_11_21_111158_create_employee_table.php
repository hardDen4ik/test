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
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('department_id');
            $table->tinyInteger('employment');
            $table->tinyInteger('payment');
            $table->float('typical_hours')->nullable();
            $table->float('annual_salary')->nullable();
            $table->float('hourly_rate')->nullable();
            $table->timestamps();

            $table->index('job_id');
            $table->index('department_id');

            $table->foreign('job_id')->references('id')->on('job')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('department')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee', function (Blueprint $table) {
           $table->dropForeign(['job_id']);
           $table->dropForeign(['department_id']);
           $table->dropIndex(['job_id']);
           $table->dropIndex(['department_id']);
        });
        Schema::dropIfExists('employee');
    }
};
