<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoyDisease extends Model
{
   public function Growth()
   {
       return $this->belongsTo(Growth::class);
   }
   public function DiseaseMenu()
   {
       return $this->belongsTo(DiseaseMenu::class);
   }
}
