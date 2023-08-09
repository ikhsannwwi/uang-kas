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
        Schema::table('kas', function (Blueprint $table) {
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->integer('status');
            $table->renameColumn('kas','pemasukan_pengeluaran');
            $table->renameColumn('user','user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
