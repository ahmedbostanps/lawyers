<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    const FILLABLE = [
        'advocate_client_id', 'owner_name', 'name'
    ];

    protected $fillable = self::FILLABLE;


    public function advocateClient(): BelongsTo
    {
        return $this->belongsTo(AdvocateClient::class);
    }

    public function contract(): BelongsToMany
    {
        return $this->belongsToMany(Contract::class, 'contract_project', 'project_id', 'contract_id');
    }

    public function scopeFilter($q)
    {

        $search = request('search');
        if (isset($search['value'])){
            $q->where('name' , 'like' , "%".$search['value']."%");
        }
    }
}
