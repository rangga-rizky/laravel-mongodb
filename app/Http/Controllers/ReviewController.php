<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use App\Place;


class ReviewController extends Controller
{

	function __construct(Review $review){
		$this->review = $review;
	}

    public function showByPlace($place_id){
    	$reviews = $this->review->where('place_id', $place_id)->get();
    	return response()->json($reviews);
    }

    public function store(Request $request){
    	$place_id = $request->place_id;
    	$place = Place::where("_id",$place_id)->first();
    	$request->validate([
    		'rating' => 'required',
    		'name' => 'required',
		]);
    	if(empty($place)){
    		abort(404);
    	}
    	
        $avg = $this->review->where("place_id",$place_id )->avg('rating');
        if(is_null($avg)){
            $avg = $request->rating;
        }
    	$count = $place->review["count"]+1;
		$place->review = array('count' => $count,'avg_stars' =>  $avg);
		$place->save();

    	$this->review->place_id = $place_id;
		$this->review->review = $request->review;
		$this->review->user = array('user_name' => $request->name);
		$this->review->rating = $request->rating;
		$this->review->save();

        return redirect('/')->withSuccess("Rewview Berhasil ditambahkan");

    }


}
