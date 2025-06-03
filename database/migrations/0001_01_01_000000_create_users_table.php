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
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps(); // created_at & updated_at
        });

        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string("order_id");
            $table->unsignedBigInteger('user_id'); // foreign key
            $table->string('status')->default('pending');
            $table->string('username');
            $table->string('kelas');
            $table->date('start_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->integer('total_durations');
            $table->timestamps();

            // foreign key ke table users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('memberships');
    }
};
