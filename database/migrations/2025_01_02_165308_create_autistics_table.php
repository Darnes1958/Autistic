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
        Schema::create('autistics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->integer('sex');
            $table->date('birthday');
            $table->foreignIdFor(\App\Models\City::class,'birth_city');
            $table->string('nat_id');
            $table->foreignIdFor(\App\Models\City::class);
            $table->foreignIdFor(\App\Models\Street::class);
            $table->foreignIdFor(\App\Models\Near::class);
            $table->foreignIdFor(\App\Models\Center::class)->nullable();
            $table->integer('academic');
            $table->string('person_name');
            $table->string('person_relationship');
            $table->foreignIdFor(\App\Models\City::class,'person_city');
            $table->string('person_phone');
            $table->json('symptoms');
            $table->integer('sym_year');
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autistics');
    }
};
