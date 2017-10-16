<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\Game;
use App\Models\GameScore;

class FBAppController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}
	public function language(){
		$locale = \Input::get('locale','en');
		\Session::put('locale',$locale);
		return redirect()->back();
	}
	public function index(){

		$max = env('MAX_ITEMS_HOME',30);
		$logined = false;
		$gamescores = [];
		if(\Auth::check()){
			$ids = [];
			$gamescores = GameScore::where('created_by',\Auth::user()->id)
							->get();
			foreach ($gamescores as $score) {
				$ids[] = $score->game_id;
			}
			$games = \DB::table('games')
							->where('custom_game',false)
							->whereNotIn('game_id',$ids)
							->orderBy('created_at','desc')
							->take(4)
							->get();
			$logined = true;
		}
		else{
			$games = Game::where('custom_game',false)
							->orderBy('created_at','desc')
							->take($max)
							->get();
		}
		$fbapp = true;
		return view('welcome',compact('games','logined','gamescores','fbapp'));
	}

	public function newpics(){
		$max = env('MAX_ITEMS_HOME',30);
		$gamescores = [];
		
		$ids = [];
		$gamescores = GameScore::where('created_by',\Auth::user()->id)
						->get();
		foreach ($gamescores as $score) {
			$ids[] = $score->game_id;
		}
		$games = \DB::table('games')
						->where('custom_game',false)
						->whereNotIn('game_id',$ids)
						->paginate(24);
		
		return view('newpics',compact('games'));
	}

	public function home(){
		$user = \Auth::user();
		$games = GameScore::where('created_by',\Auth::user()->id)
							->orderBy('created_at','desc')
							->get();
		return view('home',compact('user','games'));
	}
	public function player($username){
		$user = User::where('username',$username)->firstOrFail();
		$games = GameScore::where('created_by',$user->id)
							->orderBy('created_at','desc')
							->get();
		return view('player',compact('user','games'));
	}
	
	public function share($game_id,$user_id){
		$gameScore = GameScore::where('game_id',$game_id)
								->where('created_by',$user_id)
								->first();
		if(!$gameScore){
			abort(404);
		}
		$game = $gameScore->game();
		$user = User::find($user_id);
		return view('share',compact('gameScore','user','game'));
	}
}
