$(function(){
	__clickedButton = null;
	$('.picture-picker').click(function(){
		var url = $(this).data('url');
		if(!url){
			url = '/gallery';
		}
		__clickedButton = $(this);
		BootstrapDialog.show({
            message: function(dialog) {
                var $message = $('<div></div>');
                var pageToLoad = dialog.getData('pageToLoad');
                $message.load(pageToLoad);
        
                return $message;
            },
            data: {
                'pageToLoad': url
            }
        });
	});

	$(document).on('click','.picture-select',function(){
		var input = $(__clickedButton).parent().prev();
		if(input){
			$(input).val($(this).data('url'));
		}
		BootstrapDialog.closeAll();
	})
})