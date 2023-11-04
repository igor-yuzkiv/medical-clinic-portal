<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('login')->unique();
            $table->string('email')->nullable();
            $table->string("phone")->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer("role")->nullable();
            $table->boolean("is_active")->default(true);
            $table->dateTime('last_activity_at')->nullable();
            $table->string("source_id")->unique()->nullable();
            $table->string("gender")->default(\App\Containers\User\Enums\GenderEnum::UNKNOWN->value);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
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
