<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('doctor_patient', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("doctor_id");
            $table->foreign("doctor_id")->references("id")->on("users")->cascadeOnDelete();
            $table->unsignedBigInteger("patient_id");
            $table->foreign("patient_id")->references("id")->on("patients")->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_patient');
    }
};
