<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $table      = 'admin_role';
    protected $primaryKey = 'rid';
    protected $guarded    = [];
    public $timestamps = false;
}