<?php namespace App\Helper;

define("__WIDTH",135);
define("__HEIGHT",135);

class GameBuilder{
	public $__elements = [];
	public static function build($row,$col){
		$game = new GameBuilder();
		for($i = 1;$i<=$row;$i++){//X - ROW
			for($j = 1;$j<=$col;$j++){//Y - COL
				$element = $game->buildElement($i,$j);
				$game->__elements[] = $element;
			}	
		}
		return $game;
	}
    // .....................
    // .....................
    // ..........X..........
    // .....................
    // .....X.........X.....
    // .....................
    // ..........X..........
    // .....................
    // .....................
    public function getElement($row,$col){
        for ($i = 0;$i < count($this->__elements);$i++) {
            if($this->__elements[$i]->row == $row && $this->__elements[$i]->col == $col){
                return $this->__elements[$i];
            }
        }
        return null;
    }
    function buildElement($row,$col){
        $top=null;$right=null;$bottom=null;$left=null;
        $topElement = $this->getElement($row-1,$col);
        $rightElement = $this->getElement($row,$col+1);
        $bottomElement = $this->getElement($row+1,$col);
        $leftElement = $this->getElement($row,$col-1);
        
        if($topElement){
            $top = new JigIndex('top',!$topElement->bottom->out);
            if($row < 6)
                $bottom = new JigIndex('bottom',$this->randomOut());
        }
        else{
            if($col < 6)
                $right = new JigIndex('right',$this->randomOut());
            $bottom = new JigIndex('bottom',$this->randomOut());
        }
        
        
        if($leftElement){
            $left = new JigIndex('left',!$leftElement->right->out);
            if($col < 6)
                $right = new JigIndex('right',$this->randomOut());
        }
        else{
            $right = new JigIndex('right',$this->randomOut());
        }
        $element = new JigElement($row,$col,$top,$right,$bottom,$left);
        return $element;
    }
    public function buildElementTmpl($row,$col){
        $element = $this->getElement($row,$col);
        $tmpl_center = 'images/lib/tmpl_center.png';
        $tmpl_top_in = 'images/lib/tmpl_top_in.png';
        $tmpl_top_out = 'images/lib/tmpl_top_out.png';
        $tmpl_right_in = 'images/lib/tmpl_right_in.png';
        $tmpl_right_out = 'images/lib/tmpl_right_out.png';
        $tmpl_bottom_in = 'images/lib/tmpl_bottom_in.png';
        $tmpl_bottom_out = 'images/lib/tmpl_bottom_out.png';
        $tmpl_left_in = 'images/lib/tmpl_left_in.png';
        $tmpl_left_out = 'images/lib/tmpl_left_out.png';

        $tmpl_image = \Image::make($tmpl_center);

        $tmpl_path = '';
        if($element->top){
            if($element->top->out){
                $tmpl_image->insert($tmpl_top_out,'top');
                $tmpl_path .='top_out';
            }
            else{
                $tmpl_image->insert($tmpl_top_in,'top');
                $tmpl_path .='top_in';
            }
        }
        if($element->right){
            if($element->right->out){
                $tmpl_image->insert($tmpl_right_out,'right');
                $tmpl_path .='right_out';
            }
            else{
                $tmpl_image->insert($tmpl_right_in,'right');
                $tmpl_path .='right_in';
            }
        }
        if($element->bottom){
            if($element->bottom->out){
                $tmpl_image->insert($tmpl_bottom_out,'bottom');
                $tmpl_path .='bottom_out';
            }
            else{
                $tmpl_image->insert($tmpl_bottom_in,'bottom');
                $tmpl_path .='bottom_in';
            }
        }
        if($element->left){
            if($element->left->out){
                $tmpl_image->insert($tmpl_left_out,'left');
                $tmpl_path .='left_out';
            }
            else{
                $tmpl_image->insert($tmpl_left_in,'left');
                $tmpl_path .='left_in';
            }
        }
        if(!\File::exists('images/lib/'.$tmpl_path.'.png')){
            $tmpl_image->save('images/lib/'.$tmpl_path.'.png');
        }
    	return 'images/lib/'.$tmpl_path.'.png';
    }
    public function getElementString($row,$col){
        $element = $this->getElement($row,$col);
        $tmpl_path = '';
        if($element->top){
            if($element->top->out){
                $tmpl_path .='top_out.';
            }
            else{
                $tmpl_path .='top_in.';
            }
        }
        if($element->right){
            if($element->right->out){
                $tmpl_path .='right_out.';
            }
            else{
                $tmpl_path .='right_in.';
            }
        }
        if($element->bottom){
            if($element->bottom->out){
                $tmpl_path .='bottom_out.';
            }
            else{
                $tmpl_path .='bottom_in.';
            }
        }
        if($element->left){
            if($element->left->out){
                $tmpl_path .='left_out.';
            }
            else{
                $tmpl_path .='left_in.';
            }
        }
        return $tmpl_path;
    }
    protected function randomOut(){
        return rand(0,1) == 1;
    }
}

class JigIndex{
    public $name;
    public $out;
    public $x,$y;
    function __construct($name,$out){
    	$this->name = $name;
    	$this->out = $out;
	    switch($name){
	        case "top":
	            $this->x = __WIDTH/2;
	            $this->y = intval(__HEIGHT/3);
	            break;
	        case "bottom":
	            $this->x = __WIDTH/2;
	            $this->y = intval(__HEIGHT/3*2);
	            break;
	        case "left":
	            $this->x = intval(__WIDTH/3);
	            $this->y = __HEIGHT/2;
	            break;
	        case "right":
	            $this->x = intval(__WIDTH/3*2);
	            $this->y = __HEIGHT/2;
	            break;
	        default:
	    }
    }
}
class JigElement {
	function __construct($row,$col,$top,$right,$bottom,$left){
        $this->row = $row;
        $this->col = $col;
        $this->top = $top;
        $this->right = $right;
        $this->bottom = $bottom;
        $this->left = $left;
    }
}
class JigGroup{
    public $items = [];

    public function add($element){
    	$this->items[] = $element;
    }
}