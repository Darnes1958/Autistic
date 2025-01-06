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
        Schema::create('growths', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\autistic::class)->constrained();
            $table->integer('mother_old');
            $table->integer('pregnancy_duration');
            $table->integer('is_pregnancy_planned');
            $table->integer('mother_p_d_health');
            $table->string('p_d_why_not_health')->nullable();
            $table->integer('is_p_d_followed');
            $table->integer('is_p_d_good_food');
            $table->integer('is_child_wanted');
            $table->integer('is_p_d_diseases');
            $table->string('p_d_disease')->nullable();
            $table->integer('is_pregnancy_normal');
            $table->integer('where_pregnancy_done');
            $table->integer('pregnancy_time');
            $table->integer('child_weight');
            $table->integer('is_child_followed');
            $table->string('why_child_followed')->nullable();
            $table->integer('is_breastfeeding_natural');
            $table->integer('breastfeeding_period');
            $table->string('difficulties_during_weaning')->nullable();
            $table->integer('when_can_set');
            $table->integer('teeth_appear');
            $table->integer('could_crawl');
            $table->integer('could_stand');
            $table->integer('could_walk');
            $table->integer('when_try_speak');
            $table->integer('when_speak');
            $table->integer('when_open_door');
            $table->integer('when_set_export');
            $table->integer('when_wear_shoes');
            $table->integer('when_use_spoon');
            $table->integer('is_child_food_good');
            $table->integer('sleep_habit');
            $table->integer('is_disturbing_nightmares');
            $table->integer('safety_of_senses');
            $table->string('who_senses')->nullable();
            $table->integer('mental_health');
            $table->string('who_mental')->nullable();
            $table->integer('injuries_disabilities');
            $table->integer('is_take_medicine');
            $table->integer('prescription_image')->nullable();
            $table->integer('is_child_play_toy');
            $table->string('why_not_play_toy')->nullable();
            $table->string('is_play_with_other');
            $table->integer('slookea_1');
            $table->integer('slookea_2');
            $table->integer('slookea_3');
            $table->integer('slookea_4');
            $table->integer('slookea_5');
            $table->integer('slookea_6');
            $table->integer('slookea_7');
            $table->integer('slookea_8');
            $table->integer('slookea_9');
            $table->integer('slookea_10');
            $table->integer('slookea_other');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('growths');
    }
};
