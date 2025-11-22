<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komentar', function (Blueprint $table) {
            $table->id('id_komentar');
            $table->integer('id_artikel');
            $table->integer('id_user');
            $table->text('isi_komentar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komentar');
    }
};