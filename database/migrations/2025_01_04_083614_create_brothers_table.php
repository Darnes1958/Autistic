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
        Schema::create('brothers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\autistic::class);
            $table->foreignIdFor(\App\Models\Family::class);
            $table->string('name');
            $table->date('brother_date');
            $table->integer('brother_sex');
            $table->integer('brother_health');
            $table->integer('brother_academic');
            $table->integer('brother_job');
            $table->integer('brother_relation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brothers');
    }
};
