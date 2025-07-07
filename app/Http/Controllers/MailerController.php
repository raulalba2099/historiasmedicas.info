<?php

namespace App\Http\Controllers;

use App\Mail\RecetaMail;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class MailerController extends Controller
{
    public function email() {
        return view('consulta/153');

    }

    public function  sendMail($archivo) {

//            require base_path("vendor/autoload.php");
        try {

           $mail = new Mail();
           $mail->to('ralba2099@gmail.com')->send(

           );



        } catch (Exception $e) {

            echo back()->with('error', 'Message could not be sent');
            exit();
        }

        $this->email();
    }

    function comprobar_email($email) {
        return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? 1 : 0;
    }

}
