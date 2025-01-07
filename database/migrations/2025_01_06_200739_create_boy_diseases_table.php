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
        Schema::create('boy_diseases', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Growth::class);
            $table->string('name');
            $table->integer('age');
            $table->integer('period');
            $table->integer('intensity');
            $table->string('Treatment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boy_diseases');
    }
};
