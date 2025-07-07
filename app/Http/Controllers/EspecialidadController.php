<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{
    public function show($id) : Especialidad
    {
        return $especialidad = Especialidad::where('esp_id', $id)->first();
    }

//   static public function especilidadUser() : Especialidad {
//
//        if (!empty(auth())) {
//
//           $especialidadUser = Especialidad::where('esp_user_id', auth()->user()?->id)->first();
//
//        } else {
//           $especialidadUser = Especialidad::where('esp_id', '1')->first();
//        }
//       $especialidadUser = Especialidad::where('esp_id', '1')->first();
//         return $especialidadUser;
//
//    }
}
