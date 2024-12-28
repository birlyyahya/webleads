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
        Schema::create('history_leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads');
            $table->foreignId('user_id')->constrained('users');
            $table->string('email');
            $table->string('alamat');
            $table->string('pekerjaan');
            $table->string('hobi');
            $table->string('followup_via');
            $table->string('tanggal_followup');
            $table->enum('status', ['sudah', 'belum', 'ulang'])->default('belum');
            $table->string('keterangan');
            $table->string('tanggal_followup_lanjutan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_leads');
    }
};
