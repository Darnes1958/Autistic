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
        Schema::create('contact_procs', function (Blueprint $table) {
            $table->id();
            $table->string('proc');
            $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(\App\Models\Contact::class);
            $table->integer('proc_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_procs');
    }
};
