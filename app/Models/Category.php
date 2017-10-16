<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = ['created_by','title','active','order'];
	public function getRecent($count){
		return Game::where('category_id',$this->id)->where('custom_game',false)->orderBy('created_at','desc')->take($count)->get();
	}
	public function games(){
		return $this->hasMany('App\Models\Game');
	}
	public function last(){
		return $this->games->last();
	}
	public static function activeCategories(){
		return Category::where('active',true)->get();
	}

	public function titlize(){
		// replace non letter or digits by -
		$text = $this->title;
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		// trim
		$text = trim($text, '-');

		// remove duplicate -
		$text = preg_replace('~-+~', '-', $text);

		// lowercase
		$text = strtolower($text);

		if (empty($text)) {
			return 'n-a';
		}

		return $text;
	}
}
