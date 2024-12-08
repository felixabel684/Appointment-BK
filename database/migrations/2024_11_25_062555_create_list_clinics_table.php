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
        Schema::create('list_clinics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('complaint');
            $table->integer('queueNumber');

            $table->unsignedBigInteger('patients_id')->nullable();
            $table->foreign('patients_id')->references('id')->on('patients')->onDelete('cascade');

            $table->unsignedBigInteger('appointment_schedules_id')->nullable();
            $table->foreign('appointment_schedules_id')->references('id')->on('appointment_schedules')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_clinics');
    }
};
