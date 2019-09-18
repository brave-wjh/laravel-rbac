<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    //protected $connection = 'mysql';
    protected $table      = 'admin_user';
    protected $primaryKey = 'id';
    protected $guarded    = [];
    public $timestamps = false;
}