<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    // Extendendo o Role do Spatie
    protected $fillable = ['name', 'guard_name'];
}