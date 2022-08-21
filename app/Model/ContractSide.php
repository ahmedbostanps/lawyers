<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContractSide extends Model
{
    const SIDEONE = 1;
    const SIDETWO = 2;

    public $fillable=['id','client_id' , 'contract_id' , 'type'];

    public function client() {
        return $this->belongsTo(AdvocateClient::class , 'client_id');
    }

    public function getTypeAttribute($type) {
        if(empty($type)) {
            return "";
        }
        return [
            1 => 'طرف أول',
            2 => 'طرف ثاني'
        ][$type];
    }
    public function getOriginalTyoeAttribute() {
        return $this->attributes['type'];
    }
}
