<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Place;

class HomeController extends Controller
{
    public function index(){
    	$places = Place::all();
    	return view("home",["places" => $places]);
    }

    public function destroy(Request $request){
    	Place::destroy($request->id);
    	return redirect('/')->withSuccess("Footprint telah dihapus");
    }
}
