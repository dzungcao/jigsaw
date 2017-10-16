<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Game;
use App\Models\Picture;
use App\Models\GameScore;
use App\Helper\GameBuilder;

class CustomPicController extends Controller
{
    public function player($username){
        $user = User::where('username',$username)->first();
        return view('user',compact('user'));
    }
    public function custompic(){
        $pictures = Picture::where('created_by',\Auth::user()->id)
                            ->where('custom_pic',1)
                            ->orderBy('created_at','desc')
                            ->get();
        $games = Game::where('created_by',\Auth::user()->id)
                            ->where('custom_game',1)
                            ->orderBy('created_at','desc')
                            ->get();
        return view('custompic',compact('pictures','games'));
    }
    public function uploadPicture(Request $request){
        $file = $request->file('picture');
        $extension = $file->getClientOriginalExtension();
        $fileUrl =  time().'_'.strtolower(str_random(8)).'.'.$extension;
        
#picture validation        
        // Tell the validator that this file should be an image
        $rules = array(
          'picture' => 'mimes:jpeg,jpg,png|required|max:5000' // max 10000kb
        );
        $validator = \Validator::make(['picture'=>$file], $rules);
        if($validator->fails()){
            return \Response::make($validator->errors()->first(),400);    
        }
#end picture validation        
        $file->move(public_path().'/piclib/', $fileUrl);

        // crop image
        $img = \Image::make('piclib/'.$fileUrl);
        $img->crop(576, 576);
        $img->save();

        $inputs['path'] = $fileUrl;
        $inputs['custom_pic'] = 1;
        $inputs['created_by'] = \Auth::user()->id;
        Picture::create($inputs);

        return redirect('custompic');
    }
    public function makegame(Request $request){
        $picture_id = \Input::get('picture_id');
        $pic = Picture::findOrFail($picture_id);
        if($pic->created_by != \Auth::user()->id){
            abort(401);
        }

        $game = new Game();
        $game->game_id = strtolower(str_random(8));
        $game->created_by = \Auth::user()->id;

        
        $img = \Image::make('piclib/'.$pic->path);
        \File::makeDirectory('gamedir/'.$game->game_id);
        $gamePath = 'gamedir/'.$game->game_id.'/'.$pic->path;
        $img->save($gamePath);
        $game->original_picture = $gamePath;
        $game->time = env('TIME_DEFAULT',300);
        $game->custom_game = true;
        $game->save();

        //cut this image into 36 pieces
        $pieces = '';
        $builder = GameBuilder::build(6,6);
        $platform = env('PLATFORM','WINDOW');
        for($i = 1 ;$i<= 6;$i++){ //Y
            for($j = 1;$j<= 6;$j++){//X
                $pName = 'gamedir/'.$game->game_id.'/'.$i.''.$j.'.png';
                $x = ($i-1)*96 - 32;
                $y = ($j-1)*96 - 32;
                $jigsaw_tmpl = $builder->buildElementTmpl($i,$j);
                //$jigsaw_tmpl = 'images/lib/tmpl_center.png';
                $pieces .= $builder->getElementString($i,$j).'|';
                if($platform == 'LINUX')
                    $convert = 'convert '.$gamePath.' -crop 160x160+'.$y.'+'.$x.'\! -background none -flatten +repage '.$jigsaw_tmpl.' -alpha Off -compose CopyOpacity -composite -crop 160x160+0+0 +repage '.$pName;
                else
                    $convert = 'magick '.$gamePath.' -crop 160x160+'.$y.'+'.$x.'\! -background none -flatten +repage '.$jigsaw_tmpl.' -alpha Off -compose CopyOpacity -composite -crop 160x160+0+0 +repage '.$pName;
                exec($convert);
            }
            $pieces .= '@';
        }
        $game->pieces = $pieces;
        $game->save();
        \File::delete('piclib/'.$pic->path);
        $pic->delete();
        return back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletePicture($id)
    {
        $pic = Picture::findOrFail($id);
        if($pic->created_by != \Auth::user()->id){
            abort(401);
        }
        \File::delete('piclib/'.$pic->path);
        $pic->delete();
        return back();
    }
}
