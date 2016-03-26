/**
 * Copyright (c) 2007-2012 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * @author Ariel Flesler
 * @version 1.4.3.1
 */
(function($){var h=$.scrollTo=function(a,b,c){$(window).scrollTo(a,b,c)};h.defaults={axis:'xy',duration:parseFloat($.fn.jquery)>=1.3?0:1,limit:true};h.window=function(a){return $(window)._scrollable()};$.fn._scrollable=function(){return this.map(function(){var a=this,isWin=!a.nodeName||$.inArray(a.nodeName.toLowerCase(),['iframe','#document','html','body'])!=-1;if(!isWin)return a;var b=(a.contentWindow||a).document||a.ownerDocument||a;return/webkit/i.test(navigator.userAgent)||b.compatMode=='BackCompat'?b.body:b.documentElement})};$.fn.scrollTo=function(e,f,g){if(typeof f=='object'){g=f;f=0}if(typeof g=='function')g={onAfter:g};if(e=='max')e=9e9;g=$.extend({},h.defaults,g);f=f||g.duration;g.queue=g.queue&&g.axis.length>1;if(g.queue)f/=2;g.offset=both(g.offset);g.over=both(g.over);return this._scrollable().each(function(){if(e==null)return;var d=this,$elem=$(d),targ=e,toff,attr={},win=$elem.is('html,body');switch(typeof targ){case'number':case'string':if(/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(targ)){targ=both(targ);break}targ=$(targ,this);if(!targ.length)return;case'object':if(targ.is||targ.style)toff=(targ=$(targ)).offset()}$.each(g.axis.split(''),function(i,a){var b=a=='x'?'Left':'Top',pos=b.toLowerCase(),key='scroll'+b,old=d[key],max=h.max(d,a);if(toff){attr[key]=toff[pos]+(win?0:old-$elem.offset()[pos]);if(g.margin){attr[key]-=parseInt(targ.css('margin'+b))||0;attr[key]-=parseInt(targ.css('border'+b+'Width'))||0}attr[key]+=g.offset[pos]||0;if(g.over[pos])attr[key]+=targ[a=='x'?'width':'height']()*g.over[pos]}else{var c=targ[pos];attr[key]=c.slice&&c.slice(-1)=='%'?parseFloat(c)/100*max:c}if(g.limit&&/^\d+$/.test(attr[key]))attr[key]=attr[key]<=0?0:Math.min(attr[key],max);if(!i&&g.queue){if(old!=attr[key])animate(g.onAfterFirst);delete attr[key]}});animate(g.onAfter);function animate(a){$elem.animate(attr,f,g.easing,a&&function(){a.call(this,e,g)})}}).end()};h.max=function(a,b){var c=b=='x'?'Width':'Height',scroll='scroll'+c;if(!$(a).is('html,body'))return a[scroll]-$(a)[c.toLowerCase()]();var d='client'+c,html=a.ownerDocument.documentElement,body=a.ownerDocument.body;return Math.max(html[scroll],body[scroll])-Math.min(html[d],body[d])};function both(a){return typeof a=='object'?a:{top:a,left:a}}})(jQuery);



/**
 * Portfolio setter- displays the portfolio items separated
 * by pages and adds a category filter functionality.
 * @author Pexeto
 * http://pexeto.com 
 */

(function($){
	$.fn.portfolioSetter=function(options){
		var defaults={
			//default settings
			itemsPerPage: 12, //the number of items per page
			pageWidth: 800,  //the width of each page
			pageHeight:430,  //the height of each page
			itemMargin:30,  //margin of each of the portfolio items
			showCategories: true,  // if set to false, the categories will be hidden
			easing: 'easeOutCirc', //the animation easing
			animationSpeed: 600, //the speed of the animation of the pagination
			navButtonWidth:21,  //the width of the pagination button 
			wavyAnimation:false, //if set the true, all the elements will fade in consecutively with a wavy effect
			pageWrapperClass: 'page-wrapper',  //the class of the div that wraps the items in order to set a page
			navigationId: 'portfolio-pagination',  //the ID of the pagination div
			itemClass: 'portfolio-item', //the class of the div that wraps each portfolio item data
			columns:3	
		};
		
		options=$.extend(defaults, options);
		options.pageHolder=$(this);
		
		//define some helper variables
		var categories=[], 
			$cats = null,
			items=[], 
			pageWrappers=[], 
			imagesLoaded=0, 
			counter=0, 
			ie=false, 
			categoryHolder, 
			iesix=false,
			isResponsive = pexetoSite.isResponsive,
			root=$('<div />').css({width:(options.pageWidth*2), float:'left'}),
			parent = $(this),
			parentId=$(this).attr('id'),
			lastWidth = options.pageWidth,
			navLis = null,
			currentPage = 0,
			inAnimation = false,
			isOldIe = false,
			browser = pexetoSite.getBrowser(),
			widthDifference = isResponsive ? 1 : 0;

		parent.append(root);

	if($(this).length){
		init();
	}
	
	function init() {
		if(browser.msie && parseInt(browser.version, 10)<=8){
			isOldIe = true;
		}

		loadItems();

		if(isResponsive){
			$(window).on('resize', doOnResize);
		}
	}
	
	/**
	 * Parses the XML portfolio item data.
	 */
	function loadItems(){
		if(options.showCategories){
			//get the portfolio categories
			$cats = $('li.category');
			$cats.each(function(i){
				var current=$(this),
				category = {
					id:	current.attr('id'),
					name: current.text()
				};
				categories.push(category);
			});
		}
						
		// get the portfolio items
		$('.portfolio-item').each(function(i){
						
				var item = {
					obj:$(this),
					category:$(this).attr('title').split(',')
				};
				item.html=item.obj.html();
				
				items.push(item);
		});
					
		setSetter();
	}

	function setWrapperWidth(){
		var len = pageWrappers.length,
			wrapperWidth = getPageWidth();

		if(wrapperWidth!==lastWidth){
			root.find('.'+options.pageWrapperClass).width(wrapperWidth);
			lastWidth = wrapperWidth;
		}
		
	}

	function getPageWidth(){
		//rewrite the function depending on the browser
		getPageWidth = isOldIe ?
			function(){
				return options.pageWidth + options.itemMargin;
			} : function(){
				return parent.width()-widthDifference;
			};

		return getPageWidth();
	}

	function doOnResize(){
		setWrapperWidth();

		moveToPage(currentPage, false);

		setContainerHeight(false);
	}

	function setContainerHeight(animate){
		var height = pageWrappers[currentPage].height(),
			func = animate ? $.fn.animate : $.fn.css;

		func.call(root, {height:height});
	}
	
	
	/**
	 * Calls the main functions for setting the portfolio items.
	 */
	function setSetter(){
		if(browser.msie){
			ie=true;
			if(browser.version.substr(0,1)<7){
				iesix=true;
			}
		}
		root.siblings('.loading').remove();
		root.after('<div id="'+options.navigationId+'"><ul></ul></div>');
		if(options.showCategories){
			displayCategories();
		}
		
		displayItems();

		pageWrappers[0].find('img').each(function(){
			$(this).pexetoOnImgLoaded({callback:setContainerHeight});
		});

		if(isResponsive){
			setWrapperWidth();
		}
		
	}
	
	/**
	 * Displays the categories.
	 */
	function displayCategories(){
		categoryHolder=$('#portfolio-categories');	
		
		//add the ALL link
		var allLink= categoryHolder.find('li.all-cat');
		showSelectedCat(allLink);
		
		//bind the click event
		allLink.on('click', function(){
			displayItems();
			showSelectedCat($(this));
		});

		categoryHolder.on('click', 'li.category', doOnCategoryClick);
	}

	function doOnCategoryClick(){
		var $cat = $(this),
			id = $cat.attr('id');

		displayItems(id);
		showSelectedCat($cat);
	}
	
	function showSelectedCat(selected){
		//hide the previous selected element
		var prevSelected=categoryHolder.find('ul li.selected');
		if(prevSelected[0]){
			prevSelected.removeClass('selected');
		}
		
		//show the new selected element
		selected.addClass('selected');
	}
	
	
	/**
	 * Displays the portfolio items.
	 */
	function displayItems(){
		var filterCat=arguments.length===0?false:true;
		
		//reset the divs and arrays
		$('.portfolio-item').detach();
		
		root.html('');
		root.width(300);
		pageWrappers=[];
		root.animate({marginLeft:0});
		
		var length=items.length;	
		counter=0;
		var catId=arguments[0];
		for ( var i = 0; i < length; i++)
			(function(i, filterCat, catId) {
				
				if(!filterCat || (filterCat && items[i].category.contains(catId))){
					if(counter%options.itemsPerPage===0){
						counter=0;
						//create a new page wrapper and make the holder wider
						root.width(root.width()+options.pageWidth+20);
						var wrapper=$('<div class="'+options.pageWrapperClass+'"></div>').css({float:'left', width:getPageWidth()});
						pageWrappers.push(wrapper);
						root.append(wrapper);
					}
					
					var lastWrapper=pageWrappers[pageWrappers.length-1];
					if(!isResponsive && options.showDescriptions && counter%options.columns===0){
						lastWrapper.append('<div class="item-wrapper"></div>');
					}
					
					
					var obj = items[i].obj,
					innerDiv=!isResponsive && options.showDescriptions?lastWrapper.find('div.item-wrapper:last'):lastWrapper;
					
					innerDiv.append(obj.css({display:'none'}));

					var timeout=counter>=options.itemsPerPage?0:100;
					
					if(counter>=options.itemsPerPage || !options.wavyAnimation){
						items[i].obj.css({display:'block'});
					}else{
						setTimeout(function() {
							//display the image by fading in
							items[i].obj.fadeIn().animate({opacity:1},0);
						},counter*100);
					}
					
					

					counter++;
				}
				
		})(i,filterCat, catId);
		
		currentPage = 0;
		
		setContainerHeight(false);
				
		//show the navigation buttons
		showNavigation();

		//call cufon
		pexetoSite.loadCufon();
		
		pexetoSite.setLightbox(jQuery("#gallery a[rel^='lightbox[group]']"));
				
	}
	
	
	/**
	 * Displays the navigation buttons.
	 */
	function showNavigation(){
		//reset the divs and arrays
		var navUl=root.siblings('#'+options.navigationId).find('ul');
		navUl.html('');
		
		var pageNumber=pageWrappers.length;
		if(pageNumber>1){
			var html = '';
			for(var i=0; i<pageNumber; i++){
				html+='<li></li>';
			}

			navUl.append(html);

			navLis = navUl.find('li');

			navUl.on('click', 'li', doOnNavClick);
			
			navUl.find('li:first').addClass('selected');
			
		}
	}

	function doOnNavClick(e){
		var i = navLis.index($(this));

		if(i===currentPage){
			return;
		}
			
		if(moveToPage(i, true)){
			currentPage = i;
			$(this).addClass('selected').siblings('.selected').removeClass('selected');
		}			
	}

	function moveToPage(index, animate){
		var marginLeft,
			args = {},
			distance = 0,
			duration = 500;

		if(animate &&  inAnimation){
			return false;
		}

		if(animate){
			inAnimation = true;
		}

		marginLeft = index*lastWidth+index*options.itemMargin;

		args = {
			marginLeft : -marginLeft,
			height : pageWrappers[index].height()
		};

		if(animate){
			distance = window.scrollY - root.offset().top;
			if( distance < 500 ){
				duration = distance;
			}

			$.scrollTo(root, {duration:duration, offset:-100, onAfter: function(){
				root.animate(args, options.animationSpeed, options.easing, function(){
					inAnimation = false;
				});
			}});
		}else{
			root.css(args);
		}
		

		return true;
	}
	

	};
}(jQuery));


/**
 * Declare a function for the arrays that checks
 * whether an array contains a value.
 * @param value the value to search for
 * @return true if the array contains the value and false if the
 * array doesn't contain the value
 */
Array.prototype.contains=function(value){
	var length=this.length;
	for(var i=0; i<length; i++){
		if(this[i]===value){
			return true;
		}
	}
	return false;
};
