<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    protected $StartPagelinkslinks = [
        'navLogoLink' => '#',
        'infoLink' => '#',
        'prisLink' => '#',
        'reglerLink' => '#',
        'faqLink' => '#',
        'kontaktLink' => '#' 
    ];

    protected $users;
    protected $places;

    /*
    //--- No longer needed. these are default if not overridden ---//
    protected $links = [
        'navLogoLink' => '/',
        'infoLink' => '/#branaslagretInfo',
        'prisLink' => '/#prisInfo',
        'reglerLink' => '/#ReglerInfo',
        'faqLink' => '/#faqInfo',
        'kontaktLink' => '/#KontaktInfo' 
    ];
    */

    public function index(){
        return view('Pages/index') ->with('links', $this->StartPagelinkslinks);
    }

    public function template(){
        return view('Layouts/template');
    }

    public function login(){
        return view('Pages/login');
    }

    public function gdpr(){
        return view('Pages/gdpr');
    }

    public function dashboard(){
        return view('AdminPages/dashboard');
    }
    public function registrationlists(){
        return view('AdminPages/registrationlists');
    }

    public function manageusers(){
        $users = \App\User::all();
        return view('AdminPages/managemebers', ['users' => $users]);
    }

    public function manageuser($id){
        $user = \App\User::find($id);
        return view('AdminPages/manageuser', ['user' => $user]);
    }

    // Remove before publishing. Just temp to develop verification email
    public function testmail(){
        $registration= new \App\Registration();
        //return request()->all();
        
        $registration->first_name = 'Karl';
        $registration->last_name = 'Karlsson';
        $registration->birthdate = 1337-13-37;
        $registration->last_four = 1337;
        $registration->address = 'EliteStreet 3';
        $registration->zip = 13337;
        $registration->city = 'Ljung';
        $registration->email = 'test@test.se';
        $registration->first_name_advocate = 'Anders';
        $registration->last_name_advocate = 'Andersson';
        $registration->place = 0;

        return view('Emails/registeredemail', ['registration' => $registration, 'link' => 'branaslagret.test']);
    }
}
