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
        Schema::create('history_akses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('alat_id');
            $table->foreign('alat_id')->references('id')->on('alat')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->dateTime('waktu_akses');
            $table->string('status_pintu');
            $table->string('status_akses');
            $table->string('imei');
            $table->string('device_model');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_akses');
    }
};
