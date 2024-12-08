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
        Schema::create('examination_details', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('examinations_id')->nullable();
            $table->foreign('examinations_id')->references('id')->on('examinations')->onDelete('cascade');

            $table->unsignedBigInteger('medicines_id')->nullable();
            $table->foreign('medicines_id')->references('id')->on('medicines')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examination_detail');
    }
};
