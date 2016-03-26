/**
 * Portfolio previewer-  displays previews of the portfolio
 * items separated by pages and adds a functionality for displaying a post after
 * clicking on the smaller preview
 * 
 * @author Pexeto http://pexeto.com
 */

(function($){
	$.fn.portfolioPreviewer=function(options){
	// main default settings
		var defaults={
			xmlSourceFile : 'portfolio-preview.xml',
			itemnum : 6,
			pageWidth : 270,
			speed : 500, // will be overwritten by the XML data
			catId : -1,
			autoThumbnail:'on',
			sidebarPortionSize : 28, //the default sidebar size in percents
			sidebarPortionSizeSmall : 20, //the sidebar size in percents for small screens
			sidebarBreakPointAt : 800
		};

		
	// data containers
	var options=$.extend(defaults, options),
		items = [], 
		divContainer, 
		firstColumn, 
		wrapper, 
		pageWrappers = [], 
		currentShown = 0, 
		ie=pexetoSite.getBrowser().msie, 
		maxWrapperHeight=0,
		images=[],
		browser = pexetoSite.getBrowser(),
		isResponsive = pexetoSite.isResponsive,
		parent = $('#full-width'),
		sidebar = null,
		$items = null,
		root=$(this),
		lastSidebarWidth = 0;

	var init = function(){
		parseData();

		if(isResponsive){
			$(window).on('resize', setSidebarSize);
		}
	}

	/**
	 * Parses the data from the XML file, creates objects from the data and
	 * saves the objects into arrays.
	 */
	var parseData = function() {
		
				
		$('.portfolio-showcase-item').each(function(i) {
			var current = $(this),
				post = {};
			
			// create the object for the post
			post.obj = current.find('.preview-item:first');
			post.html = post.obj.html();
			post.smallObj = current.find('.showcase-item:first');

			items.push(post);
		});
		
		if (items.length > 0) {
			displayContent();
		}

	};

	var setSidebarSize = function(){
		setSidebarWidth();
		setWrapperHeight();
	};

	var setSidebarWidth = function(){
		if(browser.msie && (browser.version==7 || browser.version==8)){
			return;
		}
		var sidebarWidth = sidebar.width();

		if(sidebarWidth !== lastSidebarWidth){
			$items.width(sidebarWidth-4);
			lastSidebarWidth = sidebarWidth;
		}
		
	};


	/**
	 * Displays the main content of the items container.
	 */
	var displayContent = function() {
		firstColumn = $('<div id="portfolio-preview"><div class="loading"></div></div>');
		var secondColumn = $('<div class="portfolio-sidebar"><div id="portfolio-wrapper"></div></div>');
		$('.preview-items').detach();
		root.html('').append(firstColumn).append(secondColumn);
		wrapper = secondColumn.find('#portfolio-wrapper');

		// show the first post
		showFirstPost();

		// show the other posts from the right
		displayPostList();
		
	//	pexetoSite.loadCufon();
		pexetoSite.setPortfolioLightbox();

	};

	var showFirstPost = function(post) {
		firstColumn.html(items[0].obj);
	};

	/**
	 * Displays all the smaller post previews to the right, separated by pages.
	 */
	var displayPostList = function() {

		for ( var i = 0; i < items.length; i++) {
			if (i % options.itemnum === 0) {
				var pageWrapper = $('<div class="portfolio-items"></div>');
				pageWrappers.push(pageWrapper);
				wrapper.width(wrapper.width() + 500);
				wrapper.append(pageWrapper);
			}
			var post = items[i].smallObj;

			pageWrappers[pageWrappers.length - 1]
					.append(post);
		}

		sidebar = $('.portfolio-sidebar:first');
		$items = $('.showcase-item');

		if(isResponsive){
			setSidebarWidth();
		}

		//recalculate the sidebar size when the images get loaded
		$items.find('img').pexetoOnImgLoaded({callback:function(){
			setWrapperHeight();
		}});
	

		if (items.length > options.itemnum) {
			setWrapperHeight();
			showNavigation();
		}

		setPostClickHandlers();
	};
	
	var setWrapperHeight = function(){
		maxWrapperHeight = 0;

		for(var i=0,length=pageWrappers.length; i<length; i++){
			if(pageWrappers[i].height()>maxWrapperHeight){
				maxWrapperHeight=pageWrappers[i].height();
			}
			
			wrapper.height(maxWrapperHeight);
		}
	};


	/**
	 * Shows the pagination below the smaller post previews.
	 */
	var showNavigation = function() {
		wrapper
				.parent()
				.append(
						'<div id="portfolio-big-pagination"><a class="alignleft" id="prev-item"> <span class="portfolio-big-arrows">&laquo; </span><span class="nav-text">'+options.prev+'</span></a> <a class="alignright" id="next-item"><span class="nav-text"> '+options.next+'</span> <span class="portfolio-big-arrows"> &raquo;</span></a></div>');
		var prevButton = wrapper.parent().find('a#prev-item');
		var nextButton = wrapper.parent().find('a#next-item');

		// set the next button click handler
		nextButton.on('click', function(e){
			e.preventDefault();
			doOnNext();
		});

		// set the previous button click handler
		prevButton.on('click', function(e){
			e.preventDefault();
			doOnPrevious();
		});

		wrapper.touchwipe({
			wipeLeft: doOnNext,
			wipeRight: doOnPrevious,
			preventDefaultEvents: true
		});
		
		$('#portfolio-big-pagination a').hover(function(){
			$(this).css({cursor:'pointer'});
		});
	};

	var doOnNext = function(){
		if (currentShown < pageWrappers.length - 1) {
			var margin = -(currentShown + 1)
					* (options.pageWidth + 31);
			wrapper.animate( {
				marginLeft : margin
			}, options.speed);
			currentShown++;
		}
	};

	var doOnPrevious = function(){
		if (currentShown !== 0) {
			var margin = -(currentShown - 1)
					* (options.pageWidth + 31);
			wrapper.animate( {
				marginLeft :  margin
			}, options.speed);
			currentShown--;
		}
	};

	/**
	 * Sets post click handlers to the smaller previews. When a small preview post is clicked
	 * the whole content of the post is shown to the left.
	 */
	var setPostClickHandlers = function() {
		var itemsNumber = items.length;
		for ( var i = 0; i < itemsNumber; i++)
			(function(i) {
				items[i].smallObj.each(function(j) {
					$(this).bind(
							{
								'click' : function() {
									var current = items[i];

									firstColumn.html(current.obj);
									pexetoSite.setPortfolioLightbox();
								},
								'mouseover' : function() {
									$(this).css( {
										cursor : 'pointer'
									});
								}
							});
				});
			})(i);

	};
	
	if(root.length){
		init();
	}

	};
}(jQuery));