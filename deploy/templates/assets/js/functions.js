soaalarm = {
	globals : {	
		pseudoSelectors: false,
		javascriptSelector: true,
		consoleDebugging: false,
		wburl:'http://www.soaalarm.nl/'
	},
	initiate : {
		page:function(options){	
		
			options = jQuery.extend(soaalarm.globals, options);	
			
			$('input').blur(function(){
				$('input').removeClass("focus");
			}).focus(function() {                
				$(this).addClass("focus")
			});



			if(soaalarm.globals.javascriptSelector){
				$('body').removeClass('nojs')
			}	
			
			soaalarm.initiate.colHeights();
			soaalarm.initiate.hasScrollbar();
			
			if($('#soanotify form[name=setup]').length !== 0){
				soaalarm.initiate.soanotify.formCheckSetup();				
			}
			if($('#soanotify form[name=confirm_init]').length !== 0){
				soaalarm.initiate.soanotify.formCheckConfirm();				
			}
			
			if($('#subMenu *').length == 0){
				$('#subMenu').siblings('.sideShade').hide();			
			}
			
		},
		feedback:function(){
			$('body').append('<div id="feedbackbtn"><a href="#feedback" title="Geef je mening over Soa Alarm">Geef je mening</a></div>');
		},
		colHeights:function(){
			
			var cl = $('#contentContainer .colleft'),
				cr = $('#contentContainer .colright'),			
				clw = $('#contentContainer .colleft').height(),
				clr = $('#contentContainer .colright').height();
			
			if(clr < clw){
				cr.height(clw);
			}		
			
		},
		soanotify:{
			formCheckSetup:function(){			
				
				$('#soanotify [name=conditions]').attr('checked', false);
				
				function disableSubmit(){
					$('#soanotify form[name=setup] input[type=submit]').click(function(){
						return false;
					}).css({
						opacity: '0.2'
					})								
				}
				function enableSubmit(){
					$('#soanotify form[name=setup] input[type=submit]').unbind('click').css({
						opacity: '1'
					})				
				}
				
				
				disableSubmit();
								
				
				$('#soanotify form[name=setup]').change(function(){	
					
					if($('#soanotify [name=conditions]:checked').length !== 0){
						complete = true;						
					}else{
						complete = false;
					}			
					
					if(complete){
						enableSubmit();
					}
				
				})
				
				
				function is_valid_email (e){
					if(typeof(e) == 'string'){
						
						return /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(e);
					}else{
						valid = function(v){
							return /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(v);
						}
						if(!valid($(e).val())){
							$(e).addClass('invalid')
						}else{						
							$(e).removeClass('invalid')
						}						
					}		
				}
				
				
				
				$('#soanotify .val-email').live('keyup',function(){				
					is_valid_email($(this));			
									
				})
				.live('blur', function(){
					is_valid_email($(this));				
				})
				
				$('#soanotify .inp_text.duplicating').live('keyup', function(e){
					
					if(e.keyCode==188){
						date = new Date();
						date = date.getTime();
						
						if( is_valid_email($(this).val()) ){		
						
							$(this).clone(true).val('').attr({id:date,name:''}).removeClass('invalid').css({marginBottom: '5px'}).appendTo('div.multiple');
								
							$('#soanotify .multiple input:last-child').focus();
							
						}
						return false;
					}					
				}).live('blur',function(){
					$('#soanotify .inp_text.duplicating').not('#toAddress, .focus').each(function(){
						if($(this).val() == ''){
							$(this).remove();
						}
					})

				})
				
				$('#soanotify form').submit(function(){
					value = '';
					$('#soanotify .duplicating').each(function(){
						if(value == ''){
							value = $(this).val();
						}else{
							value = value + ', ' + $(this).val();
						}
					}).removeAttr('name');
					
					$('form').append('<input type="hidden" value="'+value+'" name="toAddress" />')				
					
					return true;
				})
					
			},			
			formCheckConfirm:function(){
				
				function disableSubmit(){
					$('#soanotify input[type=submit]').click(function(){
						return false;
					}).css({
						opacity: '0.2'
					})								
				}
				function enableSubmit(){
					$('#soanotify input[type=submit]').unbind('click').css({
						opacity: '1'
					})				
				}
				function checklength(value){
					if(value > 0){
						enableSubmit();					
					}else{
						disableSubmit();
					}			
					
				}
				
				$('#soanotify [name=confirmation]').change(function(){
					checklength($(this).val().length);
				});
				$('#soanotify [name=confirmation]').blur(function(){
					checklength($(this).val().length);
				})
				$('#soanotify form').change(function(){
					
					
				
				})
					
			},
			resultPage:function(){
			}
		},
		hasScrollbar:function(){
			
			var scrollpos = document.documentElement.scrollTop + $(window).height();
			var cs = 1;
			if($('body').height() < scrollpos) {
				if(cs == 1){
					var cs = 2;
					$('#share .shadow:visible').fadeOut();
				}					
			}else{					
					$('#share .shadow:hidden').fadeIn();				
			}
		
			window.onresize = function(){
				if ($(window).height() > $('body').height()){
					$('#share .shadow:visible').fadeOut();
				}else{
					$('#share .shadow:hidden').fadeIn();
				} 
			}
			window.onscroll = function(){		
				var scrollpos = document.documentElement.scrollTop + $(window).height();
				var cs = 1;
				if($('body').height() < scrollpos) {
					if(cs == 1){
						var cs = 2;
						$('#share .shadow:visible').fadeOut();
					}					
				}else{					
						$('#share .shadow:hidden').fadeIn();				
				}
			}
		}
	}
}
$(document).ready(function(){
	soaalarm.initiate.page();
});