<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{


    public function members()
    {
        return $this->hasMany(TaskMember::class);
    }

}
