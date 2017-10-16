<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Game;
use App\Models\Picture;
use App\Helper\GameBuilder;



class GameController extends Controller
{
    public function getIndex(){
        if(\Auth::user()->admin || \Auth::user()->approver || \Auth::user()->manager){
            if(\Input::has('cat_id')){
                $query = Game::where('category_id',\Input::get('cat_id'))->orderBy('created_at','desc');
            }
            else{
                $query = Game::orderBy('created_at','desc');

            }
        }
        else
            $query = Game::where('created_by',\Auth::user()->id)
                        ->orderBy('created_at','desc');
                        
        $games = $query->paginate(24);
        return view('game.index',compact('games'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postCreate()
    {
        $picture_id = \Input::get('picture_id');
        $pic = Picture::findOrFail($picture_id);
        $game = new Game();
        $game->game_id = strtolower(str_random(8));
        $game->created_by = \Auth::user()->id;

        // crop image
        $img = \Image::make('piclib/'.$pic->path);
        $img->crop(576, 576);
        \File::makeDirectory('gamedir/'.$game->game_id);
        $gamePath = 'gamedir/'.$game->game_id.'/'.$pic->path;
        $img->save($gamePath);
        $game->original_picture = $gamePath;
        $game->time = env('TIME_DEFAULT',300);
        $game->save();

        //cut this image into 36 pieces
        $row = 6;
        $col = 6;

        $pieces = '';
        $builder = GameBuilder::build($row,$col);
        $platform = env('PLATFORM','WINDOW');
        for($i = 1 ;$i<= $row;$i++){ //Y
            for($j = 1;$j<= $col;$j++){//X
                $pName = 'gamedir/'.$game->game_id.'/'.$i.''.$j.'.png';
                $x = ($i-1)*96 - 32;
                $y = ($j-1)*96 - 32;
                $jigsaw_tmpl = $builder->buildElementTmpl($i,$j);
                $pieces .= $builder->getElementString($i,$j).'|';
                if($platform == 'LINUX'){
                    $convert = 'convert '.$gamePath.' -crop 160x160+'.$y.'+'.$x.'\! -background none -flatten +repage '.$jigsaw_tmpl.' -alpha Off -compose CopyOpacity -composite -crop 160x160+0+0 +repage '.$pName;
                    \Log::info($convert);
                }
                else
                    $convert = 'magick '.$gamePath.' -crop 160x160+'.$y.'+'.$x.'\! -background none -flatten +repage '.$jigsaw_tmpl.' -alpha Off -compose CopyOpacity -composite -crop 160x160+0+0 +repage '.$pName;
                exec($convert);
            }
            $pieces .= '@';
        }
        $game->pieces = $pieces;
        $game->save();
        return redirect('/game');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postUpdate($id)
    {
        $game = Game::findOrFail($id);
        $game->title = \Input::get('title');
        $game->description = \Input::get('description');
        $game->time = \Input::get('time');
        $game->category_id = \Input::get('category_id');
        $game->save();
        return back();
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postDelete($id)
    {
        $game = Game::findOrFail($id);
        if(!\Auth::user()->admin && !\Auth::user()->manager && !\Auth::user()->approver){
            if($game->created_by != \Auth::user()->id){
                abort(401);
            }
        }
        $success = \File::deleteDirectory('gamedir/'.$game->game_id);
        $game->delete();
        return redirect('game');
    }

    public function getTest(){
        return \Response::json(GameBuilder::build());
    }
}
