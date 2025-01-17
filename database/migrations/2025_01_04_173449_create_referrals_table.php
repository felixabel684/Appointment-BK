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
        Schema::create('referrals', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('patients_id')->nullable();
            $table->foreign('patients_id')->references('id')->on('patients')->onDelete('cascade');

            $table->unsignedBigInteger('doctor_sender_id')->nullable();
            $table->foreign('doctor_sender_id')->references('id')->on('appointment_schedules')->onDelete('cascade');

            $table->unsignedBigInteger('doctor_receiver_id')->nullable();
            $table->foreign('doctor_receiver_id')->references('id')->on('appointment_schedules')->onDelete('cascade');

            $table->string('reason');

            $table->string('status')->default('Waiting');

            $table->string('note');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
