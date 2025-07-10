<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    public function paciente() {
        return $this->belongsTo(Paciente::class, 'cit_pac_id', 'pac_id');
    }

}
