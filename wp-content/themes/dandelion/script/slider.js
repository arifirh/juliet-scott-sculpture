/**
 * This is a slider with small thumbnail previews. When the smaller thumbnail is clicked,
 * a bigger preview image fades in. Also there is a pagination included for the thumbnails
 * so that when there are more of them included, they are separated by pages and users can
 * navigate through them using navigation arrows.
 * 
 * @author Pexeto
 * http://pexeto.com
 */

(function($){
	$.fn.slider=function(options){
		var defaults={
			interval:4000,   //the interval between changing the images when autoplay is turned on (in miliseconds)
			autoplay:true,   //if set to false, images won't be changed automatically, only users will be able to do it
			imgPerScroll:2,  //the number of small thumbnail images per scroll (page)
			thumbContainerId:'slider-navigation',  //the ID of the div that will contain the small thumbnails
			thumbNaviationContainerSel:'#slider-navigation-container',
			thumbWrapperSel:'#slider-navigation-wrapper',
			scrollSpeed:700,  //the speed of the thumbnail scroll (in miliseconds)
			pauseInterval:5000,  //the pause interval (in miliseconds)- when an user clicks on an image or arrow, the autoplay pauses for this interval of time
			pauseOnHover:true,
			sliderWidth:980,
			sliderHeight:370,
			disabledClass : 'disabled',
			noArrowsClass : 'no-arrows'

		};
		
		options=$.extend(defaults, options);

		var api, 
			timer =-1, 
			images=[], 
			current, 
			root, 
			thumbContainer, 
			containerNum=0, 
			itemsNum,
			inAnimation=false, 
			descBox, 
			descBottom=0,
			windowFocus=true,
			imgWrapper,
			thumbNavContainer = null,
			thumbWrapper = null,
			leftArrow = null,
			rightArrow = null,
			sliderHeight = options.sliderHeight,
			displayingItems=0,
			isResponsive = pexetoSite.isResponsive,
			arrowsVisible = false;
		
		
		root=$(this);
		thumbContainer=$('#'+options.thumbContainerId);
		thumbNavContainer = $(options.thumbNaviationContainerSel);
		thumbWrapper = $(options.thumbWrapperSel);
		current=root.find('img:first').toggleClass('current').show();
		
		
		/**
		 * Inits the slider.
		 */
		function init(){

			var $images = root.find('img');

			itemsNum = $images.length;
			
			if(itemsNum){
				setDescription();
				imgWrapper = root.find('#slider-img-wrapper');
				thumbContainer.css({visibility:'visible'});

				
				getImages();
				printScrollable();
				
				$images.pexetoOnImgLoaded({callback:doOnImagesLoaded});
				
			}
		}

		function doOnImagesLoaded(){
			$('.right').click(function(){
					api.next(500);
				});
				
				//set the timer
				if(options.autoplay){
					setTimer();
					setWindowEvents();
				}

				if(isResponsive){
					setContainerHeight();
					$(window).on('resize', doOnWindowResize);
				}
				
				root.css({height:'auto'}).animate({opacity:1}, 1500);
				thumbNavContainer.animate({opacity:1}, 1500);
				root.siblings('.loading').hide();

		}

		function setNumDisplayedItems(){
			if(api){
				displayingItems = parseInt(thumbNavContainer.css('zIndex'), 10);
			}
		}

		function setContainerHeight(){
			var curWidth = root.width(),
				sliderHeight = options.sliderHeight * curWidth / options.sliderWidth;
				
			imgWrapper.css({height:sliderHeight});
			
		}

		function doOnWindowResize(){
			setContainerHeight();
			setNumDisplayedItems();
			setArrowsVisibility();
		}

		
		function setDescription(){
			root.children().wrapAll('<div id="slider-img-wrapper" />');
			
			//append the description div
			descBox=$('<div id="description-box" ></div>');
			root.find('div:first').append(descBox);
		}
		
		/**
		 * Inserts the bigger images into an array for further use.
		 */
		function getImages(){
			root.find('img').each(function(i){
				var img=$(this).data('index', i);
				images.push(img);
				if(options.pauseOnHover && options.autoplay){
					img.hover(function(){
						stopSlider();
					},function(){
						setTimeout(function(){setTimer();}, options.interval);
					});
				}
			});
			
			var title=images[0].attr('title');
			if(title){
				descBox.html('<p>'+title+'</p>').animate({bottom:descBottom}, 700);
			}
		}
		
		/**
		 * Prints the thumbnail container.
		 */
		function printScrollable(){	
			thumbContainer.find('img:first').addClass('active');
			
			//display navigation arrows if there are more than one scrollable page
			containerNum=thumbContainer.find('div.items div').not(".thumbnail-wrapper").length;
			if(containerNum>1){
				leftArrow = $('<a class="prev browse disabled" id="left-arrow"></a>').insertBefore(thumbContainer);
				rightArrow = $('<a class="next browse" id="right-arrow"></a>').insertBefore(thumbContainer);
			}
			
			
			
			//enable the scrollable plugin
			//var scrollable=thumbContainer.scrollable({speed:options.scrollableSpeed, left:'#left-arrow', right:'#right-arrow'});
			
			var scrollable=pexetoSite.setScrollable();
			api = scrollable.data("scrollable");
			setNumDisplayedItems();
			setArrowsVisibility();
			api.onSeek = setArrowsVisibility;	
			
			setClickHandlers();
		}

		function setArrowsVisibility(){
			if(!api){
				return;
			}

			if(arrowsVisible && displayingItems>=itemsNum){
				leftArrow.hide();
				rightArrow.hide();
				arrowsVisible = false;
				thumbNavContainer.addClass(options.noArrowsClass);
				api.begin(0);
			}else if(!arrowsVisible && displayingItems<itemsNum){
				leftArrow.show();
				rightArrow.show();
				arrowsVisible = true;
				thumbNavContainer.removeClass(options.noArrowsClass);
			}

			if(!isResponsive || !arrowsVisible){
				return;
			}

			if(!isMoreToScroll(api.getIndex()+1)){
				rightArrow.addClass(options.disabledClass);
			}else if(rightArrow.hasClass(options.disabledClass)){
				rightArrow.removeClass(options.disabledClass);
			}
		}
		
		/**
		 * Set click event event handlers for the thumbnail images and navigation arrows.
		 */
		function setClickHandlers(){
			var $leftArrow = $('#left-arrow'),
				$rightArrow = $('#right-arrow');

			thumbContainer.find('img').each(function(i){
				var img=$(this);
				img.click(function(){
					if(current.data('index')!==i && !inAnimation){
						showCurrent(images[i]);
						$(".items img").removeClass("active");
						img.addClass("active");
						
						pause();
					}
				}).hover(function(){
					$(this).css({cursor:'pointer'});
				});
			});
			
			//pause the autoplay on arrow click
			thumbContainer.siblings('.browse').click(function(){
				pause();
			}).mouseover(function(){
				$(this).css({cursor:'pointer'});
			});
			
			$leftArrow.mousedown(function(){
				$(this).animate({marginLeft:-3}, 100);
			}).mouseup(function(){
				$(this).animate({marginLeft:0}, 100);
			});
			
			$rightArrow.mousedown(function(){
				$(this).animate({marginRight:-3}, 100);
			}).mouseup(function(){
				$(this).animate({marginRight:0}, 100);
			});

			thumbContainer.touchwipe({
				wipeLeft: function(){
					$rightArrow.trigger('click');
				},
				wipeRight: function(){
					$leftArrow.trigger('click');
				},
				preventDefaultEvents: false
			});
		}
		
		function setWindowEvents(){
			$(window).focus(function(){
				windowFocus=true;
				if(timer===-1){
					setTimer();
				}
			});

			$(window).blur(function(){
				windowFocus=false;
				if(timer!==-1){
					stopSlider();
				}
			});
		}
		
		/**
		 * Pauses the autoplay.
		 */
		function pause(){
		if(options.autoplay){
			stopSlider();
			setTimeout(function(){setTimer();}, options.pauseInterval);
			}
		}
		
		/**
		 * Stops the autoplay.
		 */
		function stopSlider(){
			window.clearInterval(timer);
			timer=-1;
		}
		
		/**
		 * Shows the image that has been selected.
		 * @param the image object to display
		 */
		function showCurrent(img){
			descBox.stop().css({bottom:-100});
			inAnimation=true;
			img.toggleClass('current').fadeIn(function(){
				var title=img.attr('title');
				if(title){
					descBox.html('<p>'+title+'</p>').animate({bottom:descBottom}, 700);
				}
				inAnimation=false;
			});
			
			current.fadeOut(function(){
				current.removeClass('current');	
			});
			current=img;
		}
		
		/**
		 * Sets the timer for autoplay.
		 */
		function setTimer(){
			if(timer===-1 && windowFocus){
				timer = window.setInterval(function(){showNext();}, options.interval);
			}
		}
		
		/**
		 * Shows the next image, used when autoplay is enabled.
		 */
		function showNext(){
			var nextIndex=current.data('index')===(images.length-1)?0:Number(current.data('index'))+1,
				next=images[nextIndex],
				nextContPosition=parseInt(nextIndex/options.imgPerScroll,10),
				apiIndex=api.getIndex(),
				moreToScroll = isMoreToScroll(nextContPosition);

			if(nextContPosition!==apiIndex && moreToScroll){
				api.seekTo(nextContPosition, options.scrollSpeed);
			}

			$(".items img").removeClass('active').eq(nextIndex).addClass('active');
			
			showCurrent(next);
			
		}

		function isMoreToScroll(position){
			return (containerNum - position)*options.imgPerScroll>=displayingItems;
		}
		

		if(root.length>0){
			init();
		}
		
	};
}(jQuery));