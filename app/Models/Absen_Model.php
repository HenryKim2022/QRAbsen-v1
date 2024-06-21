<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Absen_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_absen';
    protected $primaryKey = 'id_absen';
    protected $fillable = [
        'id_absen', 'status', 'detail', 'bukti', 'checkin', 'checkout', 'id_karyawan'
    ];


    protected $casts = [
        'status' => 'integer', // Cast the 'status' attribute to integer
    ];

    protected function status(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ["", "Absent", "Present", "Permit", "Unwell"][$value] ?? 'Forgot 2set status',
        );
    }


    public function generateUrl($idKaryawan, $act)
    {
        $tobeReturn = "absen-${act}?id=" . $idKaryawan;
        return $tobeReturn;
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan_Model::class, 'id_karyawan');
    }
}
