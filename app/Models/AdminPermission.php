<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    protected $table      = 'admin_permission';
    protected $primaryKey = 'pid';
    protected $guarded    = [];
    public $timestamps = false;
}