$(function(){
	'use strict';
	
	$('.form h1 span').click(function(){
		$(this).addClass('active').siblings().removeClass('active');
		
		$('.form form').hide();
		
		$('.' + $(this).data('class')).fadeIn(100);
	});

	
	
	//Hide PlaceHolder On Form Fouces
	$('[placeholder]').focus(function(){
		$(this).attr('data-text',$(this).attr('placeholder'));
		$(this).attr('placeholder', '');
		
	}).blur(function() {
		$(this).attr('placeholder',$(this).attr('data-text'));
	
	});


// Add Asterisk On Required Field

$('input').each(function(){
	
		if($(this).attr('required') === 'required'){
			$(this).after('<span class="asterisk">*</span>');
		}
	});
	
//Convert Password Field To Text Field On Hover
	
	var passField = $('.password');
	
	$('.showpass').hover(function(){
		passField.attr('type', 'text');
		
	},function() {
		passField.attr('type','password');
	
	});
	
	
//Confirmation Message on Button To Delete
	$('.confirm').click(function(){
		
		return confirm('Are You Sure To Delete ');
	});
    
//
    $('.live-name').keyup(function(){
        $('.live-preview h5').text($(this).val());
    });
    
   $('.live-desc').keyup(function(){
    $('.live-preview .desc').text($(this).val());
    });
    
   $('.live-price').keyup(function(){
    $('.live-preview .price').text('$' + $(this).val());
    });
    
  
    
});

