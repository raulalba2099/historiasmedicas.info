<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{

    use HasFactory;

    protected $table = 'pacientes';
    protected $primaryKey = 'pac_id';

    public function Citas () {
        return $this->hasMany(Cita::class, 'pac_id');
    }
}
