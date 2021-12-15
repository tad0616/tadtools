/**
* @author: tom.bran[]gmail-com
* @version: 0.9.8
* edited: August '10
* plugin name: CarouSlide
* (if you can't have fun naming your own plugin, when can you?)
*/
(function($) {
	$.fn.CarouSlide = function(userConfig) {
		// default properties for user-editable values
		$.fn.CarouSlide.config = {
			slideTime: 5000,
			animTime: 1000,
			autoAnim: false, // have slides animate automatically
			animInfinity: false, // wraps from last slide to first slide, infinitely
			alwaysNext: false, // if true: only ever animates 1 slide width
			animType: "fade", // slide, slide-vertical, fade, none
			showSlideNav: true,
			showBackNext: false,
			showPauseButton: false,
			sliderHolder: ".slider-holder", // able to use alternative nav, other than one with this class
			navContainer: ".slider-nav", // able to use alternative nav, other than one with this class
			hoverLinks: false, // allows user to change slideshow content on hover, not click
			easingStyle: null // IF jquery.easing.1.3.js plugin is added to the page, the follow easings are available: swing, easeInQuad, easeOutQuad, easeInOutQuad, easeInCubic, easeOutCubic, easeInOutCubic,easeInQuart, easeOutQuart, easeInOutQuart, easeInQuint, easeOutQuint, easeInOutQuint, easeInSine, easeOutSine, easeInOutSine, easeInExpo, easeOutExpo,easeInOutExpo, easeInCirc, easeOutCirc, easeInOutCirc, easeInElastic, easeOutElastic, easeInOutElastic, easeInBack, easeOutBack, easeInOutBack, easeInBounce, easeOutBounce, easeInOutBounce
		};

		// constructor function, to hold functions and properties for each CarouSlide implementation
		function methods(){
			this.props = {}; // properties object - holds all properties for current instance of CarouSlide
			var $m = this; // provide access to 'this' for functions (regardless of scope)

			// go to a particular slide	(pos=slide to jump to; direct indicates whether the use
			// requested a specific page - so we should re-set the timer)
			this.gotoSlide = function(pos, direct, dir){
				pos = parseInt(pos);
				if (pos != $m.props.currentSlide) { // provided we're not already on the slide we're requesting, continue
					$m.props.animReady = false;
					$m.props.prevSlide = $m.props.currentSlide;
					$m.props.direction = dir;
					$m.props.direct = direct;
					$m.props.animQueue = null;
					$m.props.oldPos = $m.props.currentSlide;
					$m.props.newPos = null;

					// if we're going directly to a slide (not just back/next)
					if ($m.props.direct) {
						if ($m.props.autoAnim &&  $m.props.animState == "play") {
							$m.resetTimer();
						}
						$m.props.currentSlide = pos;
					}
					else{
						// occurs when animating by setInterval
						$m.props.currentSlide += dir;
						if ($m.props.currentSlide >= $m.props.sCount) {$m.props.currentSlide = pos = 0;}
						if ($m.props.currentSlide < 0) {$m.props.currentSlide = pos = $m.props.sCount-1;}
					}
					// highlight the correct active item
					if ($m.props.showSlideNav) {$m.setNavActive($m.props.currentSlide);}

					// depending on the animation type, change the animation style
					switch ($m.props.animType) {
						case "none":
							newPos = $m.slideAnimSetup($m.props.sWidth,"left",pos);
							$m.props.sUL.css({"left": newPos + "px"});
							$m.props.direct = null;
							$m.props.animReady = true;
							break;

						case "slide":
							newPos = $m.slideAnimSetup($m.props.sWidth,"left",pos);
							$m.props.sUL.animate({"left": newPos + "px"}, $m.props.animTime, $m.props.easingStyle, $m.transAnimCallback);
							break;

						case "slide-vertical":
							newPos = $m.slideAnimSetup($m.props.sHeight+1,"top",pos);
							$m.props.sUL.animate({"top": newPos + "px"}, $m.props.animTime, $m.props.easingStyle, $m.transAnimCallback);
							break;

						case "fade":
							var $current = $m.props.sUL.find("> li:eq(" + $m.props.currentSlide + ")");
							var $prev = $m.props.sUL.find("> li:eq(" + $m.props.prevSlide + ")");

							$current.css("z-index", "100").animate({"opacity":"1"},$m.props.animTime, $m.transAnimCallback);
							$prev.css("z-index", "10");

							if ($m.props.prevSlide !== null) {
								setTimeout(function(){
									$prev.css("opacity","0");
								}, $m.props.animTime);
							}
							break;
						default:
					}
				}
			};

			// used in both slide and slide-vertical animations - avoiding duplication of effort
			this.slideAnimSetup = function(dim,dir,pos){
				var output;
				var minus = dir == "top" ? 0 : 1;

				if ($m.props.animInfinity) {
					if ($m.props.direct) {
						$m.resetAllSlidePositions();
						$m.props.sUL.css(dir, -(dim * $m.props.oldPos) + "px");
						output = -(dim * $m.props.currentSlide);
					}else {
						output = -dim + (dim * -$m.props.direction);
					}

				}else if ($m.props.alwaysNext) {
					$(".s-id-"+$m.props.oldPos, $m.props.sUL).remove().prependTo($m.props.sUL);
					$(".s-id-"+$m.props.currentSlide, $m.props.sUL).remove().insertAfter($(".s-id-"+$m.props.oldPos, $m.props.sUL));
					var listItem = $(".s-id-"+$m.props.oldPos, $m.props.sUL);
					$m.props.sUL.css(dir,"0px");
					output = ($m.props.sUL.css(dir).split("px")[0]-dim);
				}
				else{
					output = (dim * -pos);
				}
				return output;
			};

			// run when all transition animations complete
			this.transAnimCallback = function(){
				if($m.props.animInfinity){
					// if we are animInfinity, and going to a direct slide (not back/next),
					// reset the slide order before animating
					if($m.props.direct){
						$m.setSlideOrder($m.props.currentSlide);
					}
					// if we're going to the next slide, move the first slide to the end (for wrapping purposes)
					if($m.props.direction == 1){
						var firstSlide = $(".slide:first", $m.props.sUL);
						firstSlide.remove().appendTo($m.props.sUL);
					}
					// if we're going to the previous slide, move the last slide to the start of th stack
					else if($m.props.direction == -1){
						var lastSlide = $(".slide:last", $m.props.sUL);
						lastSlide.remove().prependTo($m.props.sUL);
					}
					// quickly re-set the visible position of the ul, so the user doesn't notice the changes above
					if($m.props.animType == "slide"){
						$m.props.sUL.css("left", -$m.props.sWidth + "px");
					}
					if($m.props.animType == "slide-vertical"){
						$m.props.sUL.css("top", -$m.props.sHeight + "px");
					}
				}
				$m.props.direct = null;
				$m.props.animReady = true;
				// if the user has requested another slide while a animation was in progress, run it now
				if($m.props.animQueue !== null){
					$m.gotoSlide($m.props.animQueue,true,null);
				}
			};

			// highlight the correct item in the slideshow nav
			this.setNavActive = function(id){
				$("li",$m.props.navContainer).removeClass("active");
				$("> li:eq(" + id + ")", $m.props.navContainer).addClass("active");
			};

			// auto increment the slideshow
			this.timerFunc = function(){
				$m.gotoSlide($m.props.currentSlide + 1, false, 1);
			};

			// reset the setInterval timer, that controls the autoAnim
			this.resetTimer = function(startNow){
				clearInterval($m.props.timer);
				$m.props.timer = setInterval($m.timerFunc, $m.props.slideTime+$m.props.animTime);
				if(startNow){
					$m.timerFunc();
				}
			};

			// put all slides back into their starting order
			this.resetAllSlidePositions = function(){
				for(var i=0; i<$m.props.sCount;i++){
					$(".s-id-"+i, $m.props.sUL).remove().appendTo($m.props.sUL);
				}
			};

			// rearrange the slides to the order defined by focusOn (as second slide)
			this.setSlideOrder = function(focusOn){
				var firstSlide = (focusOn-1 < 0 ? $m.props.sCount-1 : focusOn-1);
				for(var i=0;i<$m.props.sCount;i++){
					var thisSlide = firstSlide+i;
					if(thisSlide>=$m.props.sCount){thisSlide-=$m.props.sCount;}
					$(".s-id-"+thisSlide, $m.props.sUL).remove().appendTo($m.props.sUL);
				}
			};

			// render back/next links on the page
			this.buildBackNextLinks = function(){
				var backNextNav = '<ul class="slideshow-back-next">';
				backNextNav += '<li class="back-button"><a href="javascript:;">Back</a></li>';
				backNextNav += '<li class="next-button"><a href="javascript:;">Next</a></li>';
				backNextNav += '</ul>';
				$($m.props.sContainer).append(backNextNav);
			};

			// render pause button on the page
			this.buildPauseButton = function(){
				var pauseButton = '<p class="pause-button playing"><a href="javascript:;">Pause</a></p>';
				$($m.props.sContainer).append(pauseButton);
			};

			// build navigation for slides
			this.buildNav = function(){
				var $nav = $m.props.sUL.after('<ul class="'+$m.props.navContainerTitle+'" />');
				var $slides = $m.props.sUL.find("> li");
				var slideNavContent = "";
				for(var i=0;i<$m.props.sCount;i++){
					var ref = $slides.attr("id");
					slideNavContent+='<li><a href="#'+ref+'">Slide '+(i+1)+'</a></li>';
				}
				$("."+$m.props.navContainerTitle, $m.props.sContainer).append(slideNavContent);
			}

			// code to run when initialising the slideshow
			this.init = function(root){
				$m.props.sContainer = root;
				$($m.props.sliderHolder, $m.props.sContainer).wrap("<div class='slider-wrapper' />");
				$m.props.sWrapper = ($(".slider-wrapper",root));

				// provide styling hook for developers
				$("> ul",$m.props.sWrapper).addClass("s-active " + $m.props.animType);

				// add values to our $Default variable container, for use in rest of plugin
				$m.props.timer = null;
				$m.props.prevSlide = null; // used in animations
				$m.props.currentSlide = 0;
				$m.props.backNextContainer = ".slideshow-back-next";
				$m.props.pauseContainer = ".pause-button";
				$m.props.sRef = $($(".CarouSlide")).index($m.props.sContainer);
				$m.props.animReady = true; // forces user to wait for anim to finish before initiating next one
				$m.props.animState = !$m.props.autoAnim ? "pause" : "play";
				$m.props.sUL = $(".s-active", $m.props.sWrapper);
				$m.props.sUL.find("> li",$m.props.sWrapper).each(function(id){$(this).addClass("slide").addClass("s-id-" + id);});
				$m.props.sCount = $(".s-active > li",$m.props.sWrapper).length;
				$m.props.sWidth = $(".s-active > li",$m.props.sWrapper).outerWidth();
				$m.props.sHeight = $(".s-active > li",$m.props.sWrapper).outerHeight();
				$m.props.navContainerTitle = $m.props.navContainer.split(".")[1];

				// if we're hovering to activate links, the animation needs to be instantaneous
				if($m.props.hoverLinks == true){
					$m.props.animType = "none"
				}

				// if there is no navigation, and one has been requested, build it now
				if($m.props.showSlideNav && !$m.props.sContainer.find($m.props.navContainer).length){
					$m.buildNav();
				}
				$m.props.navContainer = $m.props.sContainer.find($m.props.navContainer);

				// if there is no animation, force off incompatible features
				if($m.props.animType == "none"){
					$m.props.animInfinity = false;
					$m.props.alwaysNext = false;
				}else{
					$m.props.hoverLinks = false;
				}

				// if 'always next', and fading between slides, make it slide (otherwise you won't see any difference)
				if($m.props.alwaysNext && $m.props.animType == "fade"){
					$m.props.animType = "slide";
				}

				// if we're fade between slides, stop the infinity/alwaysNext animation
				if($m.props.animType == "fade" && ($m.props.animInfinity || $m.props.alwaysNext)){
					//Note: animType 'fade' is incompatible with properties 'aninInfinity' and 'alwaysNext'. Both are disabled below.
					$m.props.animInfinity = false;
					$m.props.alwaysNext = false;
				}

				// animInfinity and alwaysNext are incompatible; do one or the other. AlwaysNext takes priority
				if($m.props.alwaysNext && $m.props.animInfinity){
					alert("DEVELOPER NOTICE:\n\nProperties 'alwaysNext' and 'aninInfinity' cannot both be active.\n'animInfinity' has been disabled.");
					$m.props.animInfinity = false;
				}

				// if we're sliding to infinity, hide the direct slide links
				if($m.props.animInfinity){
					$(".slide:last", $m.props.sUL).remove().prependTo($m.props.sUL);
				}

				// if showing the slideshow main nav, style it for our purposes
				if($m.props.showSlideNav){
					$("> li:first", $m.props.navContainer).addClass("active");
				}else{
					$($m.props.navContainer).hide();
				}

				// if we're auto-animating, and the pause button has been requested, render it now
				if($m.props.autoAnim && $m.props.showPauseButton){
					$m.buildPauseButton();
				}

				// if we want back/next buttons, render them now
				if($m.props.showBackNext){
					$m.buildBackNextLinks();
				}

				// depending on the animation type requested, set up the DOM accordingly
				switch ($m.props.animType) {
					case "fade":
						$("> li",$m.props.sUL).css({"opacity":"0","position":"absolute","left":0,"top":0,"z-index":10});
						$("> li:first",$m.props.sUL).css({"z-index":"100","opacity":"1"});
						break;
					case "none":
						$(".s-active", $m.props.sWrapper).width(($m.props.sWidth*$m.props.sCount)+"px");
						break;
					case "slide":
						if($m.props.animInfinity){
							$($m.props.sUL).css("left",-$m.props.sWidth+"px");
						}
						$(".s-active", $m.props.sWrapper).width(($m.props.sWidth*$m.props.sCount)+"px");
						break;
					case "slide-vertical":
						if ($m.props.animInfinity) {
							$($m.props.sUL).css("top", -$m.props.sHeight + "px");
						}
						$("> ul", $m.props.sWrapper).height(($m.props.sHeight*$m.props.sCount)+"px");
						break;
					default:
				}

				// establish auto-animation of slides
				if ($m.props.autoAnim) {$m.resetTimer();}
			};
		}

		// return object for jquery chaining
		return this.each(function(id, root) {

			var $m = new methods();
			$m.props = $.extend({}, $.fn.CarouSlide.config, userConfig);
			$m.init($(this));

			function slideLinkAction(){
				var pos = $(this).attr("rel");
				if ($m.props.animReady) {
					$m.gotoSlide(pos, true, null);
				}else {
					$m.props.animQueue = pos; // create 1-item queue, to run when the current animation is finished.
				}
			}
			// button click events
			if ($m.props.showSlideNav) {
				$("> li a", $m.props.navContainer).each(function(pos){
					// attach events to current link, and clear href (as this will be controlled entirely by jQ)
					var $events = $m.props.hoverLinks ? "mouseover click" : "click";
					$(this).attr({"href": "javascript:;","rel":pos}).bind($events, slideLinkAction);
				});
			}
			var $allSlides = $("li.slide",$m.props.sContainer);
			for(var i=0; i<$allSlides.length;i++){
				var s = $(".s-id-"+i, $m.props.sContainer);
				// find links that point to the same slide as the current link (e.g. href="#slide1") and attach event event
				var ref = s.attr("id");
				$("a[href=#"+ref+"]").attr({"href": "javascript:;","rel":i}).bind("click", slideLinkAction);
			};

			// functionality for back/next buttons
			if ($m.props.showBackNext) {
				$(".next-button", $m.props.sContainer).click(function(){
					var nextPos = $m.props.currentSlide+1 >= $m.props.sCount ? 0 : $m.props.currentSlide+1;
					if ($m.props.animReady) {
						if($m.props.animState == "play"){$m.resetTimer();}
						$m.gotoSlide(nextPos, false, 1);
					}
				});
				$(".back-button", $m.props.sContainer).click(function(){
					var prevPos = $m.props.currentSlide-1 < 0 ? $m.props.sCount-1 : $m.props.currentSlide-1;
					if ($m.props.animReady) {
						if($m.props.animState == "play"){$m.resetTimer();}
						$m.gotoSlide(prevPos, false, -1);
					}
				});
			}

			// pause/play button
			if($m.props.autoAnim && $m.props.showPauseButton){
				$($m.props.pauseContainer,$m.props.sContainer).click(function(){
					if($m.props.animState == "pause"){
						$m.props.animState = "play";
						$m.resetTimer(true);
						$(this).addClass("playing").find("a").text("pause");
					}
					else if($m.props.animState == "play"){
						$m.props.animState = "pause";
						clearInterval($m.props.timer);
						$(this).removeClass("playing").find("a").text("play");
					}
				});
			}
		});
	};
})(jQuery);