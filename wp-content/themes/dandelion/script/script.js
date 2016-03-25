
/**
 * This file contains the functionality for initializing all the scripts in the
 * site and also there are some main initial settings included here, such as
 * setting rounded corners automatically, setting the Twitter functionality,
 * etc.
 * 
 * @author Pexeto
 */

var pexetoSite;

(function($){
pexetoSite = {
	enableCufon:'off',
	lightboxOptions : {},
	initSite : function() {

		// sets the colorbox lightbox
		jQuery(".gallery a").each(function(){
			var lightbox=jQuery(this).parents('.preview-item').length?'lightbox':'lightbox[group]';
			jQuery(this).attr("rel", lightbox);
		});
		
		this.setLightbox(jQuery("a[rel^='lightbox']"));
		
		this.setTestimonialFunc();
		
		//set the tabs functionality
		jQuery("ul.tabs").tabs("div.panes > div");
		
		//set the accordion functionality
		jQuery('.accordion-container').each(function(){
			jQuery(this).tabs(jQuery(this).find('div.pane'), {tabs: 'h2', effect: 'slide', initialIndex: 0});
		});
		
		this.set_submit_comment();
		
		//SET THE SEARCH BUTTON CLICK HANDLER
		jQuery('#search_button').click(function(event){
			event.preventDefault();
			jQuery('#searchform').submit();
		});
		
		//set the hover animation of the images within anchors
		jQuery('a img').hover(function(){
			jQuery(this).stop().animate({opacity:0.85}, 300);
		},function(){
			jQuery(this).stop().animate({opacity:1}, 300);
		});
		
		this.setColumns();
		
		this.setDropDown();
		this.loadCufon();
	},
		
	loadCufon:function(){
		if(this.enableCufon==='on'){
			Cufon.replace('h1,h2,h3,h4,h5,h6,#portfolio-big-pagination,.showcase-item span,a.button span,.intro-text, a.button-small span,.drop-caps');
		}
	},
	
	
	setScrollable:function(){
		return jQuery('#slider-navigation').scrollable();
	},
	
	setPortfolioLightbox:function(){
		this.setLightbox(jQuery('a[rel="lightbox"]'));
	},
	
	setLightbox:function(elem){
		var defaults = {animation_speed:'normal', theme:'light_rounded', overlay_gallery: false, deeplinking:false},
			options = jQuery.extend(defaults, pexetoSite.lightboxOptions);

		if(!pexetoSite.lightboxOptions.enable_social_tools){
			options['social_tools']='';
		}
		elem.prettyPhoto(options);
	},
	
	/**
	 * Adds a drop down functionality.
	 */
	setDropDown:function(){
		var padding=jQuery.browser.msie?5:12;
		
		jQuery("#menu ul li").each(function(){
			if(jQuery(this).children('ul').length>0){
				jQuery(this).find('a:first').append('<span class="drop-arrow">&raquo;</span>');
			}
		});
		
		jQuery("#menu ul ul").data('padding', 15);
		jQuery("#menu ul ul ul").data('padding', 0);
		
		jQuery("#menu ul li").hover(function(){
			if(jQuery(this).children('ul.sub-menu').length>0){
				var ul = jQuery(this).find('ul:first');
				ul.stop().css({paddingTop:ul.data('padding'), height:'auto'}).slideDown(300, function()
				{
					ul.css({overflow:"visible", visibility:'visible'});
				});
			}
		}, function(){
			if(jQuery(this).children('ul.sub-menu').length>0){
				var ul = jQuery(this).find('ul:first');
				ul.stop().slideUp(300, function()
				{	
					ul.css({overflow:"hidden", display:"none"});
				});
			}
		});
		
		if(jQuery.browser.opera){
			jQuery("#menu ul li").mouseover(function(e){
				jQuery(this).css({backgroundColor:'#fff'});
			});
		}
		
		if(jQuery.browser.safari){
		var hiddenul=jQuery('<ul><li></li></ul>').css({visibility:'hidden',display:'block'});
		jQuery('#menu ul:first').find('li').not('#menu ul li li').eq(-1).append(hiddenul);
		}
	},
	
	/**
	 * Sets the testimonials accordion functionality.
	 */
	setTestimonialFunc:function(){
		jQuery('.testimonial-container').each(function(){
			jQuery(this).find('div.testim-pane:first').addClass('first');
			jQuery(this).tabs(jQuery(this).find('div.testim-pane'), {
				tabs: 'img', 
				effect: 'horizontal'
			})
		});
	},
	
	setColumns:function(){
		jQuery('#content-container .columns-wrapper').each(function(){
			if(jQuery(this).find('.nomargin').length!==1){
				jQuery(this).find('.two-columns').eq(-1).addClass('nomargin');
				jQuery(this).find('.three-columns').not('.services-box').eq(-1).addClass('nomargin');
				jQuery(this).find('.four-columns').eq(-1).addClass('nomargin');
			}
		});
	},
	
	/**
	 * Loads the Nivo image slider.
	 */
	loadNivoSlider : function(obj, effect, showButtons, showArrows, slices, speed, interval, pauseOnHover, autoplay, columns, rows) {
		obj.find('img:first').css({zIndex:10000});
		
		// load the Nivo slider	
		jQuery(window)
				.load(function() {
					obj.nivoSlider( {
						effect : effect, // Specify sets like:
						// 'fold,fade,sliceDown'
						slices : slices,
						boxCols: columns, // For box animations
					    boxRows: rows, // For box animations
						animSpeed : speed,
						pauseTime : interval,
						startSlide : 0, // Set starting Slide (0 index)
						directionNav : showArrows, // Next & Prev
						directionNavHide : true, // Only show on hover
						controlNav : showButtons, // 1,2,3...
						controlNavThumbs : false, // Use thumbnails for
						// Control
						// Nav
						controlNavThumbsFromRel : false, // Use image rel for
						// thumbs
						keyboardNav : true, // Use left & right arrows
						pauseOnHover : pauseOnHover, // Stop animation while hovering
						manualAdvance : !autoplay, // Force manual transitions
						captionOpacity : 0.8, // Universal caption opacity
						beforeChange : function() {
						},
						afterChange : function() {
						},
						slideshowEnd : function() {
						} // Triggers after all slides have been shown
					});

					// remove numbers from navigation
						jQuery('.nivo-controlNav a').html('');
						jQuery('.nivo-directionNav a').html('');

						// center the slider navigation
						var slideNumber = jQuery('.nivo-controlNav a').length;
						var slideLeft = 980 / 2 - slideNumber * 21 / 2;
						jQuery('.nivo-controlNav:first').css( {
							left : slideLeft
						});
		    });
	},
	
	set_submit_comment:function(){
		jQuery('#submit_comment_button').click(function(event){
			event.preventDefault();
			jQuery('#commentform').submit();
		});
	},

	/**
	 * Contains the functionality of the send email form. Makes the validation and
	 * sends the message.
	 */
	contact : function(options){
		var defaults = {
			emptyNameMessage : 'Please fill in your name',
			invalidEmailMessage : 'Please insert a valid email address',
			emptyQuestionMessage : 'Please write your question',
			emptyCaptchaMessage : 'Please insert the text from the image',
			sentMessage : 'Message Sent',
			wrongCaptchaMessage : "The text you have entered doesn't match the text on the image",
			actionPath:'',
			captcha: true
		},
		o=$.extend(defaults, options),
		captchaTextBox = null,
		nameTextBox = $("#name_text_box"),
		emailTextBox = $("#email_text_box"),
		questionTextArea = $("#question_text_area"),
		form = $('#submit_form'),
		valid = true;

		
		function init() {
			setSendButtonClickHandler();
			setInputClickHandler();

			if(o.captcha){
				captchaTextBox=$('input[name$="recaptcha_response_field"]').removeAttr( 'style' );
			}
			setMessageHover();
			
		}

		/**
		 * Sets the send button click event handler. Validates the inputs and if they are
		 * not valid, displays error messages. If they are valid- makes an AJAX request to the
		 * PHP script to send the message.
		 */
		function setSendButtonClickHandler() {
			var contact = pexetoSite.contact;
			$("#send_button")
					.click(function(event) {
						var name='',
							email='',
							question='',
							captcha='',
							captchaChallenge='';

						
						event.preventDefault();
						valid = true;

							// remove previous validation error messages and warning styles
							nameTextBox.removeClass('invalid');
							emailTextBox.removeClass('invalid');
							questionTextArea.removeClass('invalid');
							$('#recaptcha_widget_div').removeClass('invalid');
							$('#invalid_input').hide();
							$('#sent_successful').hide();
							$('.question_icon').remove();
							$('.contact_message').remove();
							$('#error_box').hide();

							// verify whether the name text box is empty
							name = nameTextBox.val();
							validateIfEmpty(nameTextBox, name, o.emptyNameMessage);

							// verify whether the inserted email address is valid
							email = emailTextBox.val();
							validateIfEmailValid(emailTextBox, email, o.invalidEmailMessage);

							// verify whether the question text area is empty
							question = questionTextArea.val();
							validateIfEmpty(questionTextArea, question, o.emptyQuestionMessage);

							// verify whether the captcha field is empty
							if(o.captcha){
								captcha = captchaTextBox.val(),
								captchaChallenge = $('input[name$="recaptcha_challenge_field"]').val();
								validateIfEmpty(captchaTextBox, captcha, o.emptyCaptchaMessage);
							}
							

							if (valid) {
								// show the loading icon
								$('#contact_status').html(
										'<div class="contact_loader"></div>');

								var data = {name:name, 
											question:question, 
											email:email, 
											action:'pexeto_send_email',
											recaptcha_response_field: captcha,
											recaptcha_challenge_field: captchaChallenge
										};
								if(o.captcha){
									data.recaptcha_response_field=captcha;
									data.recaptcha_challenge_field=captchaChallenge;	
								}


								$
										.ajax( {
											type : "POST",
											url : pexetoSite.ajaxurl,
											data : data,
											dataType: 'json',
											success : function(res) {
												if(res.success){
													doOnMessageSent();
												}else{
													$('#contact_status').html('');
													if(o.captcha && res.captcha_failed){
														Recaptcha.reload();
														showValidationError(captchaTextBox, o.wrongCaptchaMessage, {captcha:true});

													}else{
														doOnMessageSendFailed();
													}
												}
												
											}
										});
							}
						});
		}

		function setMessageHover(){
			form.on('mouseover', '.question_icon', function(){
				$(this).css( {
						cursor : 'pointer'
				});
				$(this).siblings('.contact_message')
					.stop().show().animate( {
						opacity : 1
					}, 200);
			}).on('mouseout', '.question_icon', function(){
				$(this).siblings('.contact_message')
					.stop().animate( {
						opacity : 0
					}).hide();
			});
		}

		function doOnMessageSent(){
			form.each(function() {
				this.reset();
			});
			$('#contact_status')
					.html(
							'<div class="check"></div><span>' + o.sentMessage + '</span>');
			setTimeout(function() {
				$('#contact_status').fadeOut(
						500,
						function() {
							$(this).html('')
									.show();
						});
			}, 3000);
		}

		function doOnMessageSendFailed(){
			$('#error_box').animate({"height":"show"});
		}

		function setInputClickHandler() {
			$('#submit_form input, #submit_form textarea').on("focusin", function() {
				$(this).removeClass('invalid');
			});
		}

		function validateIfEmpty(field, value, message){
			if (value == '' || value == null) {
				showValidationError(field, message, {});
			}
		}

		function validateIfEmailValid(field, value, message){
			if (!isValidEmailAddress(value)) {
				showValidationError(field, message, {});
			}
		}

		function showValidationError(field, message, options){
				if(options.captcha){
					$('#recaptcha_widget_div').addClass('invalid');
				}else{
					field.addClass('invalid');
				}
				valid = false;
				$('<div class="question_icon"></div><div class="contact_message"><p>' + message + '</p></div>')
					.insertAfter(field);
		}

		/**
		 * Checks if an email address is a valid one.
		 * 
		 * @param emailAddress
		 *            the email address to validate
		 * @return true if the address is a valid one
		 */
		function isValidEmailAddress(emailAddress) {
			var pattern = new RegExp(
					/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
			return pattern.test(emailAddress);
		}

		init();
	}		
};
}(jQuery));






/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright Â© 2008 George McGinley Smith
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
*/

// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158; 
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: function (x, t, b, c, d) {
		return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
	},
	easeOutBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	easeInOutBounce: function (x, t, b, c, d) {
		if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
	}
});

/*
 *
 * TERMS OF USE - EASING EQUATIONS
 * 
 * Open source under the BSD License. 
 * 
 * Copyright Â© 2001 Robert Penner
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
 */





