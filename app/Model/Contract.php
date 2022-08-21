<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    public $fillable = ['is_active','status'];

    public function client_sides() {
        return $this->hasMany(ContractSide::class , 'client_id');
    }
    public function client_sides_side_one() {
        return $this->hasMany(ContractSide::class , 'contract_id')->where('type' , ContractSide::SIDEONE)
            ->with('client');
    }
    public function client_sides_side_two() {
        return $this->hasMany(ContractSide::class , 'contract_id')->where('type' , ContractSide::SIDETWO);
    }
    public function conract_sides() {
        return $this->hasMany(ContractSide::class , 'contract_id');
    }

    public function getStatusAttribute($status) {
        if(empty($status)) {
            return "";
        }
        return [
            1 => 'جديد'
        ][$status];
    }

    public function getOriginalAttribute() {
        return $this->attributes['status'];
    }

    public function conract_terms() {
        return $this->hasMany(ContractClientTerm::class , 'contract_id');
    }
}
