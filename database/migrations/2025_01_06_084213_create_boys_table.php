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
        Schema::create('boys', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\autistic::class)->constrained();
            $table->string('as_father_say');
            $table->string('as_mother_say');
            $table->integer('how_past');
            $table->string('past_problem');
            $table->integer('with_people');
            $table->integer('with_motion');
            $table->integer('with_language');
            $table->integer('with_personal');
            $table->string('other_boy_info')->nullable();
            $table->foreignIdFor(\App\Models\Ambitiou::class)->constrained();
            $table->integer('father_procedure');
            $table->integer('mother_procedure');
            $table->integer('brother_procedure');
            $table->integer('boy_response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boys');
    }
};
