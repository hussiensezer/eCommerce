$(function(){
	'use strict';
	
	
	// DashBoard 
	
	$('.toggel-info').click(function(){
		
		$(this).toggleClass('selected').parent().next('.card-body').fadeToggle(100);
		
		if($(this).hasClass('selected')) {
			$(this).html('<i class="fas fa-plus fa-lg"></i>');
		}else {
			$(this).html('<i class="fas fa-minus fa-lg"></i>');
		}
		
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



$('.child-link').hover(function(){
   $(this).find('.show-delete').fadeIn(400);
},function () {
     $(this).find('.show-delete').fadeOut(400);
    });
});