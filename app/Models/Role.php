<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    const SUPER_ADMIN = 1;
    const ADMIN = 2;
    const STAFF = 3;
    const FACULTY = 4;
    const STUDENT = 5;

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
