!function(){function t(){__timer=setInterval(function(){return __GAME_STARTED?(__TIME_COUNTER-=1,$("#game-time").text(" "+parseInt(__TIME_COUNTER/60)+"m"+parseInt(__TIME_COUNTER%60)+"s"),void(__TIME_COUNTER<=0&&(__GAME_STARTED=!1,clearInterval(__timer),a()))):(clearInterval(__timer),!1)},1e3)}function e(t){for(var e=__SIZE,_=1;_<l.width/t&&(l.add(new fabric.Line([e*_,0,e*_,6*e],{stroke:"#000000",strokeWidth:1,selectable:!1,strokeDashArray:[5,5]})),l.add(new fabric.Line([0,e*_,6*e,e*_],{stroke:"#000000",strokeWidth:1,selectable:!1,strokeDashArray:[5,5]})),!(_>=6));_++);}function _(){l.forEachObject(function(t){t.opacity=1})}function o(t){if(!E&&!t.target.locked){if(t.target.setCoords(),!__GAME_STARTED)return l.deactivateAll(),l.renderAll(),t.target.lockMovementX=!0,void(t.target.lockMovementY=!0);t.target.top<-1*__SIZE?t.target.top=-1*__SIZE:t.target.top>5*__SIZE&&(t.target.top=5*__SIZE),t.target.left<-1*__SIZE?t.target.left=-1*__SIZE:t.target.left>__WINDOW_SIZE-__SIZE&&(t.target.left=__WINDOW_SIZE-__SIZE),l.forEachObject(function(e){e==t.target||e.locked||(e.opacity=.5)}),n(t.target)&&null==__timeout&&(__timeout=setTimeout(function(){if(n(t.target)){E=!0,t.target.locked=!0;var e=c(t.target);t.target.top=e.y-5*__SIZE/3/2,t.target.left=e.x-5*__SIZE/3/2,t.target.lockMovementX=!0,t.target.lockMovementY=!0,t.target.sendToBack(),__piece_count+=1,$("#game-progress").css("width",+parseInt(__piece_count/36*100)+"%"),36==__piece_count&&(__GAME_STARTED=!1,r()),E=!1,l.forEachObject(function(e){e!=t.target&&(e.opacity=1)}),clearTimeout(__timeout),__timeout=null}else clearTimeout(__timeout),__timeout=null},400))}}function a(){l.deactivateAll().renderAll(),setTimeout(function(){$("#game-over").show()},800)}function r(){$.ajax({url:"/score",type:"POST",data:{game_id:__game_id,_token:$('meta[property="csrf_token"]').attr("content"),time:__TIME_COUNTER},success:function(t){t.success}}),setTimeout(function(){$("#final-time").text("YOU HAVE "+parseInt(__TIME_COUNTER/60)+"m"+parseInt(__TIME_COUNTER%60)+"s REMAINING"),$("#game-complete").show()},800)}function n(t){var e=s(t),_=c(t);return i(e,_)<4}function i(t,e){if(t.y-e.y==0)return Math.abs(t.x-e.x);if(t.x-e.x==0)return Math.abs(t.y-e.y);var _=Math.sqrt(Math.abs((t.y-e.y)*(t.x-e.x)));return _}function c(t){return{y:t.row*__SIZE-__SIZE/2,x:t.col*__SIZE-__SIZE/2}}function s(t){return{x:t.left+5*__SIZE/3/2,y:t.top+5*__SIZE/3/2}}__APP_DOMAIN=$('meta[property="app_domain"]').attr("content"),__SIZE=parseInt(parseInt($(".game-section").width())/6),__WINDOW_SIZE=parseInt($(".container").css("width"))-30,__WINDOW_SIZE<6*__SIZE&&(__WINDOW_SIZE=6*__SIZE),__SIZE>90&&(__SIZE=90),__elements=[],__GAME_LOADED=!1,__GAME_STARTED=!1,__TIME_COUNTER=$("#game_time").val(),__piece_count=0,__timer=null,__timeout=null,__SHOW=!1,__game_id=null,__user_id=$('meta[property="user_id"]').attr("content"),$("#game-cover").css("width",6*__SIZE+"px").css("height",6*__SIZE+"px"),$("img.piece").css("width",5*__SIZE/3+"px !important").css("height",5*__SIZE/3+"px !important"),$("#game-share").css("width",6*__SIZE+"px"),$("#section-bottom").css("width",6*__SIZE+"px"),$(".game-nav").css("width",6*__SIZE+"px");var l=this.__canvas=new fabric.Canvas("canvas",{hoverCursor:"pointer",selection:!1,width:__WINDOW_SIZE,height:6*__SIZE});$("#start-btn").show(),$(".showonloaded").show();var E=!1;l.on({"object:moving":o,"mouse:up":_}),e(__SIZE),__game_id=$("#game_id").val(),$.ajax({url:"/load/"+__game_id,type:"GET",success:function(t){$("body").waitForImages(function(){setTimeout(function(){__GAME_LOADED=!0,$("#start-btn").text("START GAME")},1500);for(var e=0;e<t.pieces.length;e++){var _=t.pieces[e];image=document.getElementById(_.row+""+_.col);var o=new fabric.Image(image,{left:fabric.util.getRandomInt(0,__WINDOW_SIZE-160),top:fabric.util.getRandomInt(0,6*__SIZE-5*__SIZE/3)});o.perPixelTargetFind=!0,o.locked=!1,o.row=_.row,o.col=_.col,o.str_top=_.cells.top,o.str_right=_.cells.right,o.str_bottom=_.cells.bottom,o.str_left=_.cells.left,o.width=5*__SIZE/3,o.height=5*__SIZE/3,o.lockMovementX=!0,o.lockMovementY=!0,o.hasControls=o.hasBorders=!1,l.add(o)}})}}),$("#btn-help").click(function(){return!!__GAME_STARTED&&(__SHOW?($("#game-cover").hide(),$(this).text("HELP")):($("#game-cover").show(),$(this).text("HIDE")),void(__SHOW=!__SHOW))}),$(".close-btn").click(function(){$("#game-complete").hide(),$("#game-over").hide()}),$("#share-btn").click(function(){__user_id>0&&(link="http://"+__APP_DOMAIN+"/share/"+__game_id+"/"+__user_id),FB.ui({method:"share",display:"popup",href:link},function(t){})}),$("#start-btn").click(function(){__GAME_LOADED&&(l.forEachObject(function(t){t.lockMovementX=!1,t.lockMovementY=!1}),$("#canvas").show(),$("#btn-playagain").show(),$("#btn-help").show(),__GAME_STARTED=!0,$(this).hide(),$("#game-cover").hide(),t(),$.ajax({url:"/count",type:"POST",data:{game_id:__game_id,_token:$('meta[property="csrf_token"]').attr("content")},success:function(t){}}))})}();