<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'key_name', 'value'
    ];
    protected $table = "admin_setting";
}
