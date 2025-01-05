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
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\autistic::class)->constrained();
            $table->string('father_name');
            $table->foreignIdFor(\App\Models\City::class,'father_city')->constrained();
            $table->date('father_date');
            $table->integer('father_academic');
            $table->string('father_job');
            $table->integer('is_father_life');
            $table->string('father_dead_reason')->nullable();
            $table->date('faher_daed_date')->nullable();
            $table->string('mother_name');
            $table->foreignIdFor(\App\Models\City::class,'mother_city')->constrained();
            $table->date('mother_date');
            $table->integer('mother_academic');
            $table->string('mother_job');
            $table->integer('is_mother_life');
            $table->string('mother_dead_reason')->nullable();
            $table->date('mother_dead_date')->nullable();
            $table->integer('Number_of_marriages');
            $table->integer('number_of_separation');
            $table->integer('Number_of_pregnancies');
            $table->integer('Number_of_miscarriages');
            $table->string('father_Chronic_diseases')->nullable();
            $table->string('mother_Chronic_diseases')->nullable();
            $table->integer('is_parent_relationship');
            $table->string('father_blood_type');
            $table->integer('mother_blood_type');
            $table->integer('parent_relationship_nature');
            $table->foreignIdFor(\App\Models\Disease::class,'family_disease')->nullable();
            $table->integer('family_salary');
            $table->integer('family_sources');
            $table->integer('house_type');
            $table->integer('house_narrow');
            $table->integer('house_health');
            $table->integer('house_old');
            $table->integer('house_own');
            $table->integer('is_house_good');
            $table->integer('house_rooms');
            $table->integer('is_room_single');
            $table->integer('other_family_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
