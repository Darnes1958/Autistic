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
        Schema::create('grow_difficults', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Growth::class);
            $table->string('name');
            $table->integer('age');
            $table->string('procedures');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grow_difficults');
    }
};
