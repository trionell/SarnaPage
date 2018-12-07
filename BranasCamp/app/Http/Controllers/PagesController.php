<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\URL;

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
    protected $camp;

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
        $camp = \App\registration_state::find(1);
        return view('Pages/index', ['links' => $this->StartPagelinkslinks, 'camp' => $camp]);
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
        $places = \App\place::all();
        $placesStats = [];

        for($i = 0; $i < count($places); $i++){
            $placesStats[] = new PlacesStats();
            end($placesStats)->place = $places[$i]->placename;

            $amountLeaders = \App\registrations_leader::where('place', '=', $places[$i]->placeID)->count();
            $amounParticipants = \App\registration::where('place', '=', $places[$i]->placeID)->count();

            end($placesStats)->amount = $amountLeaders + $amounParticipants;
        }

        return view('AdminPages/dashboard', ['placesStats' => $placesStats]);
    }
    public function registrationlists($type){

        $placesIDArray = [];
        $user = Auth::user();
        $places = \App\place::all();

        if($user->can('ljung')){
            $placesIDArray[] = \App\place::where('placename', '=', 'Ljung')->first()->placeID;
        }
        if($user->can('asklanda_ornunga')){
            $placesIDArray[] = \App\place::where('placename', '=', 'Asklanda-Ornunga')->first()->placeID;
        }
        if($user->can('bergstena_ostadkulle')){
            $placesIDArray[] = \App\place::where('placename', '=', 'Bergstena-Östadkulle')->first()->placeID;
        }
        if($user->can('borgstena_tamta')){
            $placesIDArray[] = \App\place::where('placename', '=', 'Borgstena/Tämta')->first()->placeID;
        }
        if($user->can('herrljunga')){
            $placesIDArray[] = \App\place::where('placename', '=', 'Herrljunga')->first()->placeID;
        }
        if($user->can('ljurhalla')){
            $placesIDArray[] = \App\place::where('placename', '=', 'Ljurhalla')->first()->placeID;
        }
        if($user->can('storsjostrand')){
            $placesIDArray[] = \App\place::where('placename', '=', 'Storsjöstrand')->first()->placeID;
        }
        if($user->can('t_r_e')){
            $placesIDArray[] = \App\place::where('placename', '=', 'Tåstorp/Rensvist/Eggvena/Lagmansholm')->first()->placeID;
        }
        if($user->can('vargarda')){
            $placesIDArray[] = \App\place::where('placename', '=', 'Vårgårda')->first()->placeID;
        }


        $regAmount = \App\registrations_leader::count() + \App\registration::count();
        
        if($type == 'participant'){
            $registrations = \App\registration::whereIn('place', $placesIDArray)->get();
            return view('AdminPages/registrationlists', ['registrations' => $registrations, 'places' => $places, 'count' => $regAmount, 'type' => $type]);
        }else if($type == 'leader'){
            $registrations_leaders = \App\registrations_leader::whereIn('place', $placesIDArray)->get();
            return view('AdminPages/registrationlists', ['registrations' => $registrations_leaders, 'places' => $places, 'count' => $regAmount, 'type' => $type]);
        }else {
            return redirect('/invalidaddress');
        }
    }

    public function manageusers(){
        $users = \App\User::all();
        return view('AdminPages/managemebers', ['users' => $users]);
    }

    public function manageuser($id){
        $user = \App\User::find($id);
        $access = \App\accesslevel::find($id);
        return view('AdminPages/manageuser', ['user' => $user, 'access' => $access]);
    }

    public function registrationfull(){
        return view('Pages/registrationfull');
    }

    public function registrationExists(){
        return view('Pages/registrationexist');
    }

    public function managecamps(){
        $camps = \App\registration_state::all();
        return view('AdminPages/managecamps', ['camps' => $camps]);
    }

    public function managecamp($id){
        $camp = \App\registration_state::find($id);
        return view('AdminPages/managecamp', ['camp' => $camp]);
    }

    public function CloseRegistration($id){
        $camp = \App\registration_state::find($id);
        $camp->open = 0;
        $camp->save();
        return redirect('/admin/managecamp/camp/' . $camp->id);
    }

    public function OpenRegistration($id){
        $camp = \App\registration_state::find($id);
        $camp->open = 1;
        $camp->late_open = 0;
        $camp->save();
        return redirect('/admin/managecamp/camp/' . $camp->id);
    }

    public function CloseLateRegistration($id){
        $camp = \App\registration_state::find($id);
        $camp->late_open = 0;
        $camp->save();
        return redirect('/admin/managecamp/camp/' . $camp->id);
    }

    public function OpenLateRegistration($id){
        $camp = \App\registration_state::find($id);
        $camp->open = 0;
        $camp->late_open = 1;
        $camp->save();
        return redirect('/admin/managecamp/camp/' . $camp->id);
    }

    public function About(){
        return view('Pages/about');
    }

    public function invalidaddress(){
        return view('Pages/invalidaddress');
    }

    public function lateregistration(){
        $links = \App\late_registration_key::all();
        return view('AdminPages/lateregistration', ['links' => $links]);
    }

    public function addLateRegistration(){
        $newLinkEntry = new \App\late_registration_key();
        $newLinkEntry->link_key = Request('message');
        if(Request('leader') == null){
            $newLink = url("/lateregistration") .'/'.Request('message');
            $newLinkEntry->leader = 0;
        }
        else {
            $newLink = url("/lateregistration-leader") .'/'.Request('message'); 
            $newLinkEntry->leader = 1;
        }
        $links = \App\late_registration_key::all();

        // Checks if link already exists
        foreach($links as $link){
            if($newLink == $link->link){
                return redirect('/');
            }
        }

        $newLinkEntry->link = $newLink;
        $newLinkEntry->save();

        return redirect('/admin/lateregistration');
    }

    public function removeLateRegistration($id){
        $link = \App\late_registration_key::find($id);
        $link->delete();
        return redirect('/admin/lateregistration');
    }

    public function NewAdminTemplateTemp(){
        return view('AdminPages/betaAdminTemplate');
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

class PlacesStats {
    public $place;
    public $amount;
}
