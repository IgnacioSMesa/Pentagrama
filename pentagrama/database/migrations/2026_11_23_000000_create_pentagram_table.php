<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pentagrams', function (Blueprint $table) {
            $table->id();
            // 1:N: un usuario tiene muchos pentagrams
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('instrument');   // clave del catálogo de instruments.js
            $table->json('notes');          // array de MIDI: [60, 62, 64, ...]

            // auditoría
            $table->timestamps();           // created_at / updated_at
            $table->softDeletes();          // deleted_at
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pentagrams');
    }
};
