<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Collection;

class ContractClientTerm extends Model
{
    public $fillable=['id','term_category_id' , 'contract_id' , 'contract_term_id'];

    public function category() {
        return $this->belongsTo(ContractCategory::class , 'term_category_id');
    }

    public function term() {
        return $this->belongsTo(ContractTerms::class , 'contract_term_id');
    }
    public function get_terms() {
        $items = self::where('contract_id' , $this->contract_id)->where('term_category_id' , $this->term_category_id)->get();
        return $items;
    }

    public function get_category_terms() {
        $items = ContractTerms::query()->where('category_id' , $this->term_category_id)->get();
        return $items;
    }
}
