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
        Schema::create('hostories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('admin_id')
                ->constrained('users', 'id')
                ->nullable()
                ->default(null);
            $table->foreignId('barang_id')->constrained('barang', 'id');
            $table->integer('qty');
            $table->date('date');
            $table->enum('status', ['diajukan', 'ditolak', 'dipinjam', 'dikembalikan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hostories');
    }
};
