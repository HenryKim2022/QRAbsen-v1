<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;


class TheApp_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_settings';
    protected $primaryKey = 'id_setting';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'na_setting',
        'text_setting',
        'status_setting',
        'url_setting'
    ];

    protected $casts = [
        'status_setting' => 'integer', // Cast the 'type' attribute to integer
    ];

    protected function status(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ["NotActive", "Active"][$value],
        );
    }
}
