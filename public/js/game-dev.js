(function() {
	__APP_DOMAIN = $('meta[property="app_domain"]').attr('content');
	__SIZE 	= parseInt((parseInt($('.game-section').width()))/6) ;
	__WINDOW_SIZE = parseInt($('.container').css('width')) - 30;
	if(__WINDOW_SIZE < __SIZE * 6) __WINDOW_SIZE = __SIZE * 6;
	if(__SIZE > 90) __SIZE = 90;
	__elements 	= [];
	__GAME_LOADED = false;
	__GAME_STARTED = false;
	__TIME_COUNTER = $('#game_time').val();
	__piece_count = 0;
	__timer = null;
	__timeout = null;
	__SHOW = false;
	__game_id = null;
	__user_id = $('meta[property="user_id"]').attr('content');
	$('#game-cover').css('width',__SIZE*6 + 'px')
					.css('height',__SIZE*6 + 'px');
	$('img.piece').css('width',__SIZE*5/3 + 'px !important')
				.css('height',__SIZE*5/3 + 'px !important');
	$('#game-share').css('width',__SIZE*6 + 'px');
	$('#section-bottom').css('width',__SIZE*6 + 'px');
	
	$('.game-nav').css('width',__SIZE*6 + 'px');
	var canvas 	= this.__canvas = new fabric.Canvas('canvas', {
		hoverCursor: 'pointer',
		selection: false,
		width: __WINDOW_SIZE,
		height: __SIZE*6,
	});
	$('#start-btn').show();
	$('.showonloaded').show();
	var lock = false;
	var groups = [];
	canvas.on({
				'object:moving': onChange,
				'mouse:up':mouseUp,
			});
	draw_grid(__SIZE);
	__game_id = $('#game_id').val();
	$.ajax({
		url : '/load/'+__game_id,
		type: 'GET',
		
		success:function(response){
			$('body').waitForImages(function() {
				setTimeout(function(){
					__GAME_LOADED = true;
					$('#start-btn').text('START GAME');
				},1500)
			    
				for (var i = 0; i < response.pieces.length; i++) {
					var p = response.pieces[i];
					image = document.getElementById(p.row+''+p.col);
					image.row = p.row;
					image.col = p.col;
					
					//{y: image.row * __SIZE - __SIZE/2,x: image.col * __SIZE - __SIZE/2}
					var img = new fabric.Image(image,{
						left: (image.col-1) * __SIZE - __SIZE/3,
					  	top: (image.row-1) * __SIZE - __SIZE/3,
						width: __SIZE*5/3,
						height: __SIZE*5/3
					});
					img.row = p.row;
					img.col = p.col;
					var rect = new fabric.Rect({
					    width: __SIZE*6, height: __SIZE*6, left: 0, top: 0,
					    fill: 'white',
					    opacity: 0
					  });

					var group = new fabric.Group([rect,img], {
						left: fabric.util.getRandomInt(0,400),
					  	top: fabric.util.getRandomInt(0,400),
					  	width: __SIZE*6,
					  	height: __SIZE*6,
					  	fill: '#aaa'
					});

					
				    group.perPixelTargetFind = true;
					group.lockMovementX = true;
					group.lockMovementY = true;
					//group.hasControls = group.hasBorders = false;
					group.hasBorders = true;
					//img.hasControls = img.hasBorders = false;

					canvas.add(group);
					//canvas.add(img);
				}
			});
		}
	})
	$('#btn-help').click(function(){
		if(!__GAME_STARTED) return false;
		if(__SHOW){
			$('#game-cover').hide();
			$(this).text('HELP');
		}
		else{
			$('#game-cover').show();
			$(this).text('HIDE');
		}
		__SHOW = !__SHOW;
	})
	$('.close-btn').click(function(){
		$('#game-complete').hide();
		$('#game-over').hide();
	})
	$('#share-btn').click(function(){
		if(__user_id > 0){
			link = 'http://'+__APP_DOMAIN+'/share/' + __game_id + '/' + __user_id;
		}
		FB.ui({
		    method: 'share',
		    display: 'popup',
		    href: link,
		  }, function(response){});
	})
	$('#start-btn').click(function(){
		if(__GAME_LOADED){
			canvas.forEachObject(function(obj){
				obj.lockMovementX = false;
				obj.lockMovementY = false;
				
			});
			$('#canvas').show();
			$('#btn-playagain').show();
			$('#btn-help').show();
			__GAME_STARTED = true;
			$(this).hide();
			$('#game-cover').hide();
			start_timer_counter();

			$.ajax({
				url : '/count',
				type: 'POST',
				data: {'game_id':__game_id,'_token':$('meta[property="csrf_token"]').attr('content')},
				success:function(response){
					
				}
			})
		}
	})
	function merge_group(group1,group2){
		var items = group2.getObjects('image');
		

		for (var i = 0; i < items.length; i++) {
			console.log(items[i]);
			var item = items[i];

			var image = document.getElementById(item.row+''+item.col);
			image.row = item.row;
			image.col = item.col;
			
			//{y: image.row * __SIZE - __SIZE/2,x: image.col * __SIZE - __SIZE/2}
			var img = new fabric.Image(image,{
				left: 0,
			  	top: 0,
				width: __SIZE*5/3,
				height: __SIZE*5/3				
			});
			img.row = item.row;
			img.col = item.col;
			group2.remove(item);
			group1.add(img);
		}
		group1.setCoords();
		group2.destroy();
	}
	function start_timer_counter(){
		__timer = setInterval(function(){
			if(!__GAME_STARTED){
				clearInterval(__timer);
				return false;
			}
			__TIME_COUNTER -= 1;
			$('#game-time').text(' ' + parseInt(__TIME_COUNTER/60) + 'm' + parseInt(__TIME_COUNTER %60) + 's');
			if(__TIME_COUNTER <= 0){
				__GAME_STARTED = false;
				clearInterval(__timer);
				game_over();
			}
		},1000);
	}
	function draw_grid(gridsize) {
		var size = __SIZE;
		for(var x=1;x<(canvas.width/gridsize);x++){
            canvas.add(new fabric.Line([size*x, 0, size*x, size*6],{ stroke: "#000000", strokeWidth: 1, selectable:false, strokeDashArray: [5, 5]}));
            canvas.add(new fabric.Line([0, size*x, size*6, size*x],{ stroke: "#000000", strokeWidth: 1, selectable:false, strokeDashArray: [5, 5]}));
          	if(x >=6) break;
        }
	}
	function mouseUp(){
		canvas.forEachObject(function(obj){
			obj.opacity = 1;
		});
	}
	function onChange(options) {
		if(lock) return;
		if(!__GAME_STARTED) {
			canvas.deactivateAll();
			canvas.renderAll();

			options.target.lockMovementX = true;
			options.target.lockMovementY = true;
			return;
		}
		options.target.setCoords();
		
		canvas.forEachObject(function(obj){
			if(obj != options.target){
				obj.opacity = 0.5;
			}
		});
		

		canvas.forEachObject(function(obj) {
			if (obj === options.target) return;
			if(options.target.intersectsWithObject(obj)){
				if(check_position(options.target,obj) && __timeout == null){
					__timeout = setTimeout(function(){
						if(check_position(options.target,obj)){
							lock = true;
							console.log('Y');
							merge_group(options.target,obj);
							lock = false;
							/*lock = true;
							options.target.locked = true;
			  				var pos = get_position(options.target);
			  				options.target.top = pos.y - __SIZE*5/3/2;
			  				options.target.left = pos.x - __SIZE*5/3/2;
							options.target.lockMovementX = true;
			  				options.target.lockMovementY = true;
			  				options.target.sendToBack();
			  				__piece_count += 1;
							$('#game-progress').css('width',+ parseInt(__piece_count / 36.0*100) + '%');
							if(__piece_count == 36){
								__GAME_STARTED = false;
								game_complete();
							}

							lock = false;

							canvas.forEachObject(function(obj){
								if(obj != options.target){
									obj.opacity = 1;
								}
							});*/
							clearTimeout(__timeout)
							__timeout = null;
						}
						else{
							clearTimeout(__timeout)
							__timeout = null
						}
						
					},400)
				}
			}
	    });

		
	}
	function game_over(){
		canvas.deactivateAll().renderAll();
		setTimeout(function(){
			$('#game-over').show();
		},800);
	}
	function game_complete(){
		$.ajax({
			url : '/score',
			type: 'POST',
			data: {'game_id':__game_id,'_token':$('meta[property="csrf_token"]').attr('content'),'time':__TIME_COUNTER},
			success:function(response){
				if(response.success){
					console.log('Success');
				}
				else
					console.log('Failed');
			}
		})
		setTimeout(function(){
			$('#final-time').text('YOU HAVE ' + parseInt(__TIME_COUNTER/60) + 'm' + parseInt(__TIME_COUNTER %60) + 's REMAINING');
			$('#game-complete').show();
		},800);
	}
	
	function check_position(group1,group2){
		var point1 = get_abs_position(group1);
		var point2 = get_abs_position(group2);
		if(check_dist(point1,point2) < 4){
			return true;
		}
		return false;
	}
	function check_dist(point1,point2){
		if(point1.y-point2.y == 0) return Math.abs(point1.x-point2.x);
		if(point1.x-point2.x == 0) return Math.abs(point1.y-point2.y);

		var dist = Math.sqrt(Math.abs((point1.y-point2.y)*(point1.x-point2.x)));
		return dist;
	}
	function get_position(obj){
		return {y: obj.row * __SIZE - __SIZE/2,x: obj.col * __SIZE - __SIZE/2}
	}
	function get_abs_position(obj){
		return {x: obj.left + __SIZE*3,y: obj.top + __SIZE*3}
	}
})();