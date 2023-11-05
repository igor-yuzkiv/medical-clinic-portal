<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("doctor_id");
            $table->unsignedBigInteger("patient_id");
            $table->dateTime("date_time");
            $table->integer("service_type");

            $table->foreign("doctor_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade");

            $table->foreign("patient_id")
                ->references("id")
                ->on("patients")
                ->onDelete("cascade");

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
