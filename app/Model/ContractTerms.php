<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContractTerms extends Model
{
    public $fillable=['id','name' , 'category_id'];

    public function category() {
        return $this->belongsTo(ContractCategory::class , 'category_id');
    }
}
