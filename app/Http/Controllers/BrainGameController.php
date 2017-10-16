<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\FlashGame;

class BrainGameController extends Controller
{
	public function index(){
		$flashgames = FlashGame::where('active',true)
						->orderBy('title')
						->get();
		return view('braingame.index',compact('flashgames'));
	}
	public function play($id){
		$flashgame = FlashGame::findOrFail($id);
		return view('braingame.play',compact('flashgame'));
	}

	public function getAdmin(){
		$flashgames = FlashGame::orderBy('title')
						->get();
		return view('braingame.admin',compact('flashgames'));
	}
	public function getCreate(){
		return view('braingame.create');
	}
	public function postCreate(){
		$rules = ['title'=>'required','link'=>'required'];
		$validator = \Validator::make(\Input::all(),$rules);
		if($validator->fails()){
			return back()->withErrors($validator)->withInput();
		}
		$inputs = \Input::all();
		FlashGame::create($inputs);
		return redirect('brain-game/admin');
	}
	public function postUpdate($id){
		$rules = ['title'=>'required','link'=>'required'];
		$validator = \Validator::make(\Input::all(),$rules);
		if($validator->fails()){
			return back()->withErrors($validator)->withInput();
		}
		$game = FlashGame::findOrFail($id);
		$inputs = \Input::all();
		$game->fill($inputs);
		$game->save();
		return \Response::json(['success'=>true]);
	}
}
