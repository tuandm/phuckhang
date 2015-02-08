var isTouchDevice =  'ontouchstart' in window || 'onmsgesturechange' in window;
var isDesktop = $(window).width() != 0 && !isTouchDevice ? true : false;
var isTouchIE =  navigator.userAgent.toLowerCase().indexOf('msie') != -1 && navigator.msMaxTouchPoints > 0;
var isIE11 = !!window.MSStream;
var isiPad = navigator.userAgent.indexOf('iPad') != -1;
var isiPhone = navigator.userAgent.indexOf('iPhone') != -1;
var isiPod = navigator.userAgent.indexOf('iPod') != -1;
var isAndroid = navigator.userAgent.indexOf('Android') != -1; 
var isIE = navigator.userAgent.toLowerCase().indexOf('msie') != -1 && $(window).width() != 0; 
var isChrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
var isFirefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
var isSafari = navigator.userAgent.toLowerCase().indexOf('safari') > -1;
var IEMobile = "-ms-user-select" in document.documentElement.style && navigator.userAgent.match(/IEMobile\/10\.0/);
var match = navigator.userAgent.match('MSIE (.)');
var version = match && match.length > 1 ? match[1] : 'unknown';
var DoneLoad = 0;
var View = 0;
var hostname = location.hostname;	


$(document).ready(function () {
$('body').queryLoader({ barColor: "#a70e13", percentage: true, barHeight:2, completeAnimation: "grow",  minimumTime:100});	
});

function initialize() {
	var httpserver = $('.httpserver').text();
	var httptemplate = $('.httptemplate').text();
	var infoboxdesc = $('.infobox-desc').text();
	var infoboxlocationlat = $('.infobox-location-lat').text();
	var infoboxlocationlng = $('.infobox-location-lng').text();
	var infoboximage = $('.infobox-image').text();
	var infoboxgooglemap = $('.infobox-googlemap').text();
	
	  var styles = [
		  {
			stylers: [
			  { hue: "#00619e" },
			  { saturation: -20 }
			]
		  },{
			featureType: "road",
			elementType: "geometry",
			stylers: [
			  { lightness: 100 },
			  { visibility: "simplified" }
			]
		  },{
			featureType: "road",
			elementType: "labels",
			stylers: [
			  { visibility: "on" }
			]
		  }
		];

	  var styledMap = new google.maps.StyledMapType(styles,
      {name: "Styled Map"});
	
	
	  var mapOptions = {
	  center: new google.maps.LatLng(infoboxlocationlat,infoboxlocationlng),
	  zoom: 17,
	  scrollwheel: false,
	  draggable:true,
	  draggingCursor: 'move',
	  noclear: true,
	  disableDefaultUI: true,
	  disableDoubleClickZoom : true,
	  mapTypeControlOptions: {
      mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style'],
      position: google.maps.ControlPosition.TOP_RIGHT
	  }
	  
	  };
	  
	 

	  
	  var map = new google.maps.Map(document.getElementById("map-canvas"),mapOptions);
	  var styledMapOptions = { name: "AN GIA INVESTMENT" };
	 
	 
	  map.mapTypes.set('map_style', styledMap);
      map.setMapTypeId('map_style');
	  
	  var logo = httpserver + 'pictures/logo-map.png';
	  marker = new google.maps.Marker({
	  map: map,
	  draggable:false,
	  animation: google.maps.Animation.DROP,
	  zIndex: -1,
	  height:"170px",
	  width:"150px",
	  position: new google.maps.LatLng(infoboxlocationlat,infoboxlocationlng),
	  icon: logo
	  });
	  
	 
	 google.maps.event.addListener(marker, 'mouseover', bounceAnimationMarker);
	 google.maps.event.addListener(marker, 'mouseout', clearAnimationMarker);
	 function bounceAnimationMarker() { marker.setAnimation(google.maps.Animation.BOUNCE);}
	 function clearAnimationMarker() {marker.setAnimation(null);}
	 var url = infoboxgooglemap
	
	 
	  if($(window).width() > 1100){
	      google.maps.event.addListener(marker, 'click', openBox);
	  }else{
		  google.maps.event.addListener(marker, 'click', function() {
           window.open(url, '_blank');
        });
	  }
	  
	  function openBox() {
	  clearAnimationMarker();
	  var boxText = document.createElement("div");
	  boxText.innerHTML = 
	  "<div class='infobox'>"
	  +"<img src='"+infoboximage+"' width='380px' height='132px' alt='Angia-investment' >"
	  +infoboxdesc
	  +"</div>"; 
	  
	  var myOptions = {
		 content: boxText
		,disableAutoPan: true
		,maxWidth: 400
		,pixelOffset: new google.maps.Size(-150, -200)
		,boxStyle: {background: "transparent",opacity: 1 ,width: "400px"}
		,closeBoxMargin: "10px 0 0 60px"
		,closeBoxzIndex: "99999"
		,closeBoxPosition: "absolute"
		,closeBoxURL: httptemplate+"default/images/close_s.png"
		,infoBoxClearance: new google.maps.Size(1, 1)
		,isHidden: false
		,pane: "floatPane"
		,enableEventPropagation: true
	  };
	  
	  var showinfo = new InfoBox(myOptions);
	  showinfo.open(map, marker);	
	    
	  }
	 
	  
	   ZoomControl(map);
 }





function ZoomControl(map) {
  $('.zoom-control a').click(function ()  {
   var zoom = map.getZoom();
	switch ($(this).attr("id")) {
	case "zoom-in":
		map.setZoom(++zoom);
		break;
	case "zoom-out":
		map.setZoom(--zoom);
		break;
	default:
		break
	}
	return false
  
 });

}













function ResizeWindows() {
var Portrait = $(window).height() > $(window).width();
var Landscape = $(window).height() <= $(window).width();
var img = $('.bg img, .color-bg img');
var Xwidth = $(window).width();
var Yheight = $(window).height();
var RatioScreeen = Yheight / Xwidth;
var RatioIMG = 787 / 1440;
var newXwidth;
var newYheight;
if(RatioScreeen > RatioIMG){
	  newYheight = Yheight;
	  newXwidth	= Yheight / RatioIMG;
 }else{
	  newYheight = Xwidth * RatioIMG;
	  newXwidth	= Xwidth;
	  
}

if( Xwidth > 1100){	  
      $(img).css({'width': newXwidth,'height': newYheight,'left':(Xwidth - newXwidth) / 2,'top':'auto', 'bottom':0});
      $('.slide-full, .bg, .bg-page').css({'width':Xwidth, 'height':Yheight});
}else{
	if(Xwidth < 350){
	     $(img).css({'width': Xwidth+200, 'height': (Xwidth+200)* RatioIMG, 'left':-100,	'top':0, 'bottom':'auto'});
	     $('.slide-full, .bg, .bg-page').css({'width':Xwidth, 'height':(Xwidth+200) * RatioIMG});
	}else{
		 $(img).css({'width': Xwidth, 'height': Xwidth * RatioIMG, 'left':0,	'top':0, 'bottom':'auto'});
	     $('.slide-full, .bg, .bg-page').css({'width':Xwidth, 'height':Xwidth * RatioIMG});
	}
}     


if( $('.album-load').length){
  $('.album-center').css({'height':Yheight, 'width':Xwidth});
  $('.album-pic-center').css({'height':Yheight, 'width':Xwidth});
}   
$('.full').css({'width':Xwidth, 'height':Yheight});      


$(".news-text p em").each(function(index, element) {
	/*if (!$(element).find('strong').length) {
		$(element).parent().css({'margin-top':'-15px'});
	}*/
	if ($(element).parent().contents().length==1) {
		$(element).parent().css({'margin-top':'-10px'});
	}else{
		$(element).parent().css({'margin-top':'0px'});
	}
});
		 
				 if(Xwidth <= 1100){
					 News = 1;  
					 shownews = 0;
					 Scroll = 1;
					 Click = 1;
					$('.nav-click, .nav-option, .sub-click').css({'display':'block', 'opacity':1});
					$('.navigation').css({'width':0});
					
					 if($('#recruitment-page').length){
					     $('.sub-nav').css({'height':0, 'top':0, 'margin-top':0});
					 }else{
						 $('.sub-nav, .sub-list').css({'height':0, 'top':-90, 'margin-top':0}); 
					 }
					 if(Xwidth < 890)
					 	$('.stage ul li .title-stage h6 p span').css({'display':'none'});
					else
					 	$('.stage ul li .title-stage h6 p span').css({'display':'inline-block'}); 
					 
					 
					$('.sub-click').css({'top':10, 'margin-top':0});
					$('.navigation, .sub-nav').addClass('animation');
					$('.right').css({'display':'none'});
					$('.center, .bottom, .bg-page').addClass('clearfix');
					$('.illustrator').removeClass('fadeinup');
					$('.scroll-down').css({'top':Yheight-66});
					$('.top').css({'top':0});
					$('.number-home, .news-home, .video-home').css({'display':'block'});
					$('.scrollA, .scrollB, .scrollC, .scrollD, .scrollE, .scrollF, .scrollG').getNiceScroll().remove();
			        $('.scrollA, .scrollB, .scrollC, .scrollD, .scrollE, .scrollF, .scrollG')
					.css({'height':'auto','width':'100%', 'position':'relative','overflow':'visible', 'left':'auto', 'top':'auto', 'float':'left'});
				    $('.content-page').css({'width':Xwidth, 'height':'auto'});
					$('.box-content').css({'height':'auto','width':Xwidth, 'left':'auto'});
					$('.colum-box, .colum-box.project, .colum-box-news, .colum-box-news-details')
					.css({'height':'auto', 'width':Xwidth,'max-width':'inherit', 'top':0, 'left':0});
					$('.about-box').css({'height':'auto', 'width':Xwidth, 'max-width':'inherit', 'top':'auto', 'left':'auto'});
					$('.pro-detail-box, .pro-detail-box.news-full, .recruitment-box, .news-all')
					.css({'height':'auto', 'width':Xwidth, 'max-width':'inherit', 'top':0, 'left':0, 'right':'auto'});
					$('.box-house').css({'height':'auto', 'left':0});
					$('.house-detail').css({'width':Xwidth,'height':'auto'});
					$('.pic-library').css({'height':'auto'});
					$('.content-page').css({'min-height':Yheight});
					
				    
                      $('.pic-right').css({'height':Xwidth/4});  
					  
					
					 if(Portrait){
						 $('.house-pic').css({'height':Xwidth-100});
						 $('.house-pic img').css({'height':'auto', 'margin':'0 5%', 'width':'90%'});
						
					 }else{
						 $('.house-pic').css({'height':Xwidth/2});
					     $('.house-pic img').css({'height':'auto', 'margin':'0 15%','width':'70%'});
						 
					 }
					
					    var allItem2 = $('.house-detail').length;
		                var widthItem2 = $('.house-detail').width()+100; 
		                $('.box-house').width(allItem2 * widthItem2);
					
					
					
					
					 
					
					    if($('.link-page').length<2){
							  $('.list-icon').css({'display':'none'});  
						  }else{
							  $('.list-icon').css({'display':'block', 'right':-$('.list-icon').width()-70}); 
						  }
						 var allItemX = $('.link-page').length;
						 var heightItemX = $('.link-page').height()+2; 
						 $('.news-right').height(allItemX * heightItemX);
						 $('.news-list, .news-list li').css({'height':'100%'});
						 $('.news-list ul').css({'width':250, 'left':0, 'height':'auto'}); 	
						 $('.list-close, .news-nav').css({'display':'none'}); 
					     $('.news-right').css({'left':-256, 'right':'auto','height':340});
						 $('.news-right').addClass('animation');
					
					 
					  if($('#news-details-page').length || $('#search-page').length){
							$('.news-right').css({'top':10});
					  }else{
						   $('.news-right').css({'top':55});
					  }
					 
					 $('.googlemap').css({'width':Xwidth, 'height':450}); 
					 $('#map-canvas').css({'width':Xwidth, 'height':450});
					 
					  var DH = $(document).innerHeight();
					  var windscroll = $(document).scrollTop();
			          $('.overlay-dark, .overlay-album').css({'width':Xwidth,'height':DH});
					  if(DH > Yheight + 100){
			            $('.scroll-down').css({'display':'block', 'opacity':1});
			          }else{
				        $('.scroll-down').css({'display':'none', 'opacity':0});
			          }
					  
				    	$('.overlay-menu, .overlay-dark').css({'width':Xwidth,'height':DH}); 
					    	
					
					
                      
						
						 if(DoneLoad == 1 && View == 0){
                          $('body').css({'overflow-x':'hidden','overflow-y':'auto','height':Yheight, 'width':Xwidth});
						  $('.container').css({'height':'auto'});
						   if (IEMobile || isTouchIE || isIE11) {
								 $('body').css({'overflow-x':'hidden','overflow-y':'hidden'}); 
								 $('body').getNiceScroll().resize();
							   }
					   }else if(View == 1){
                           $('body').css({'overflow':'hidden','height':Yheight, 'width':Xwidth});  
						   $('.container').css({'height':Yheight});    
		               }else{
			              $('body').css({'overflow':'hidden','height':Yheight, 'width':Xwidth}); 
						  $('.container').css({'height':Yheight});
		                }
						
					 
					 
				 }else if( Xwidth > 1100){
					  News = 0;
					  Scroll = 0;
					  Click = 0;
					 $('.nav-click, .nav-option, .sub-click').css({'display':'none','opacity':0});	
					 $('.navigation').css({'width':'100%'});
					 $('.navigation, .sub-nav').removeClass('animation');
					 $('.scroll-down').css({'display':'none', 'opacity':0});
					 $('.right, .logo').css({'display':'block'});
					 $('.slide-full, .bg, .bg-page').css({'width':Xwidth, 'height':Yheight});
					 $('.center, .bottom, .bg-page').removeClass('clearfix');
					 $('.container').css({'height':Yheight});
					 $('.top').css({'top':0});
					 $('.sub-nav, .sub-list').css({'height':340, 'margin-top':0, 'top':140});
					 $('.number-home, .news-home, .video-home').css({'display':'none'});
					 $('.overlay-dark, .overlay-album').css({'width':Xwidth,'height':Yheight});
					 $('.scrollA, .scrollB, .scrollC, .scrollD, .scrollE, .scrollF, .scrollG').css({'position':'absolute', 'overflow':'hidden','float':'none'});
					 $('.overlay-menu').css({'width':0, 'height':0});
				     $('.shadow').css({'width':Xwidth, 'height':Yheight-100});
					 $('.content-page').css({'height':Yheight-100, 'width':Xwidth});
					 $('.box-content').css({'height':Yheight-100});
					 $('.colum-box').css({'height':Yheight-100, 'width':Xwidth});
					 $('.scroll-list').getNiceScroll().remove();
					 $('.scroll-list').css({'overflow':'hidden'});
					 $('.stage ul li .title-stage h6 p span').css({'display':'inline-block'}); 
					  
					  
					  
					  
							 var allItemX = $('.link-page').length;
		                     var heightItemX = $('.link-page').height()+2; 
							 var allIX = $('.news-list li').length;
							 var widthItemX = $('.news-list li').width()+5; 
		                     $('.news-list, .news-list li').height(allItemX * heightItemX);
							 $('.news-right').height(allItemX * heightItemX)+80;
							 $('.news-list ul').width(allIX * widthItemX);
							 $('.news-list ul').css({'height':335});
							  if($('.news-list li').length <= 1){
								  $('.news-nav').css({'display':'none'});
							  }else{
								  $('.news-nav').css({'display':'block', 'top': $('.news-list').height()+2});
							  }
						   $('.list-icon, .list-close').css({'display':'none'});
						   $('.news-right').removeClass('animation');
						   $('.news-right').css({'top':50 });
					  
					
					
					
					if( Yheight > 700){	
					   $('.pro-detail-box').css({'height':Yheight-255, 'width':Xwidth-270, 'max-width':1500, 'top':40});
					   $('.scrollB').css({'height':Yheight-255, 'width':'35%', 'left':'65%','top':0});
					   $('.scrollC').css({'height':Yheight-270, 'width':'100%', 'left':0,'top':0});
					  
				    }else{
						$('.pro-detail-box').css({'height':Yheight-220, 'width':Xwidth-270, 'max-width':1500, 'top':20});
						$('.scrollB').css({'height':Yheight-220, 'width':'35%', 'left':'65%','top':0});
						$('.scrollC').css({'height':Yheight-210, 'width':'100%', 'left':0,'top':0});
				    }
					
					
					if( Xwidth > 1500){	
					   $('.about-box').css({'height':Yheight-180, 'width':Xwidth-280, 'max-width':1050, 'top':40, 'left':Xwidth/2 - $('.about-box').width()/2+25});
					   $('.bg-white').css({'height':Yheight, 'width':Xwidth-280, 'max-width':1050, 'top':0, 'left':Xwidth/2 - $('.about-box').width()/2+25});
					   $('.scrollA').css({'height':Yheight-240, 'left':0,'top':50});
				    }else{
					    $('.about-box').css({'height':Yheight-140, 'width':Xwidth-280, 'max-width':1050, 'top':20, 'left':280});
						$('.bg-white').css({'height':Yheight, 'width':Xwidth-280, 'max-width':1050, 'top':0, 'left':280});
						$('.scrollA').css({'height':Yheight-200, 'left':0,'top':50});
				    }
					
				      var picW = $('.pic-right img').width()-50;
                      $('.pic-right').css({'height':picW/4}); 
					
					if( Xwidth <= 1600){
						$('.pro-detail-box').css({'left':270, 'right':'auto'});
						$('.pro-detail-box.news-full').css({'height':Yheight-180, 'width':Xwidth-270, 'max-width':1500, 'top':0, 'left':270, 'right':'auto'});
						$('.colum-box-news-details').css({'height':Yheight-100, 'width':Xwidth-200, 'max-width':1452, 'top':0, 'left':2});
						$('.recruitment-box, .news-all').css({'height':Yheight-100, 'width':Xwidth-320, 'max-width':1200, 'top':0, 'left':270});
					}else{
						$('.pro-detail-box').css({'left':'auto', 'right':20});
						$('.pro-detail-box.news-full').css({'height':Yheight-180, 'width':Xwidth-270, 'max-width':1500, 'top':0, 'left':'auto', 'right':20});
						$('.colum-box-news-details')
						.css({'height':Yheight-100, 'width':Xwidth-200, 'max-width':1452, 'top':0, 'left':Xwidth/2 - $('.colum-box-news-details').width()/2});
						$('.recruitment-box, .news-all')
						.css({'height':Yheight-100, 'width':Xwidth-320, 'max-width':1200, 'top':0, 'left':Xwidth/2 - $('.recruitment-box, .news-all').width()/2+50});
					}
					
					
					
					
					 $('.box-house').css({'height':$('.pro-detail-box').height(), 'left':0});
					 $('.house-detail').css({'height':$('.pro-detail-box').height(), 'width': $('.pro-detail-box').width()});
					 $('.house-pic').css({'height':$('.pro-detail-box').height()});
					 $('.pic-library').css({'height':$('.pro-detail-box').height()/2+50});
					
					 
					 if($('#news-details-page').length){
						$('.colum-box-news').css({'height':'100%', 'width':$('.colum-box-news-details').width()-252,'max-width':1202, 'right':0, 'left':'auto'}); 
						$('.news-right').css({'right':'auto',  'left':3});
					 }else if($('#project-details-page').length){
						$('.colum-box-news').css({'height':'100%', 'width':$('.pro-detail-box').width()-252,'max-width':1202, 'right':'auto', 'left':0}); 
						$('.news-right').css({'right':'auto',  'left':$('.colum-box-news').width()+2});
						 
					 }
					
					   
					 $('.scrollD').css({'height':Yheight-180, 'width':$('.pro-detail-box').width()-252, 'max-width':1202, 'left':0,'top':0});
					 $('.scrollE').css({'height':Yheight-100, 'width':$('.colum-box-news-details').width()-252, 'left':0,'top':0});
					 $('.scrollF').css({'height':Yheight-100, 'width':$('.recruitment-box, .news-all').width(), 'left':0,'top':0});
					 $('.scrollG').css({'height':Yheight-180, 'width':$('.recruitment-box').width(), 'left':0,'top':0});
					  if(Yheight / Xwidth > 0.6){
						  $('.house-pic img').css({'height':'80%', 'margin':'10% auto', 'width':'auto'});
						  $('.about-box.full-size').css({'left':Xwidth/2 - $('.about-box').width()/2-100});
					  }else{
						  $('.house-pic img').css({'height':'100%', 'margin':'0 auto', 'width':'auto'});
						  
					  }
					  
					   var allItem = $('.colum-box').length;
		                var widthItem = $('.colum-box').width()+100; 
		                $('.box-content').width(allItem * widthItem);
						
						var allItem2 = $('.house-detail').length;
		                var widthItem2 = $('.house-detail').width()+100; 
		                $('.box-house').width(allItem2 * widthItem2);
					  
					  
					    
					   	if($('#search-page').length){
						  $('.news-right').css({'display':'none'});
						  $('.colum-box-news-details').css({'height':Yheight-100, 'width':Xwidth-270, 'max-width':1050, 'top':0, 'left':Xwidth/2 - ($('.colum-box-news-details').width()/2-70)});
						  $('.scrollE').css({'height':Yheight-100, 'width':$('.colum-box-news-details').width(), 'left':0,'top':0});
					   }
					
					 
					 
					  var ImgW = $('.full img').width();
		              var ImgH = $('.full img').height();
					  if(Xwidth > ImgW){
						  $('.full img').css({ 'margin-left': Xwidth / 2 - ImgW / 2 });
					  }else{
						  $('.full img').css({ 'margin-left': 0 });
					  }
					   if(Yheight > ImgH){
						  $('.full img').css({ 'margin-top': Yheight / 2 - ImgH / 2 });
					  }else{
						  $('.full img').css({ 'margin-top': 0 });
					  }
					   
					$('.googlemap').css({'width':Xwidth, 'height':Yheight}); 
					$('#map-canvas').css({'width':Xwidth+600, 'height':Yheight});
					$('body').css({'overflow':'hidden','height':Yheight, 'width':Xwidth});  
					 if (IEMobile || isTouchIE || isIE11) {
						 $('body').getNiceScroll().hide();
					 }  
						
				   
		       }
			   
			   
			   

			
}








function Done() {
   DoneLoad = 1;
   ResizeWindows();
   ContentLoad();
   $('.center, .bottom').stop().animate({'opacity':1},500 ,'linear');
    if (IEMobile || isTouchIE || isIE11) {
	   $('body').css({'overflow-x':'hidden','overflow-y':'hidden'}); 
	   $('body').niceScroll({touchbehavior: true, horizrailenabled: false, cursordragontouch:true, zindex:200,  cursorcolor:"rgba(0,0,0,0.5)",});
	   $('body').getNiceScroll().show();
	 }
}





(function($) {
	
    if (!Array.prototype.indexOf)
	   {
	   Array.prototype.indexOf = function(elt /*, from*/)
             {
             var len  = this.length >>> 0;
             var from = Number(arguments[1]) || 0;
                 from = (from < 0)
                      ? Math.ceil(from)
                      : Math.floor(from);
             if (from < 0)
                 from += len;
 
                 for (; from < len; from++)
                     {
                     if (from in this &&
                     this[from] === elt)
                     return from;
                     }
             return -1;
             };
       }

    var Yheight = $(window).height();
    var Xwidth = $(window).width();	
    var qLimages = new Array;
    var qLdone = 0;
    var qLdestroyed = false;
    var qLimageContainer = "";
    var qLoverlay = "";
    var qLbar = "";
    var qLpercentage = "";
    var qLimageCounter = 0;
    var qLstart = 0;

    var qLoptions = {
        onComplete: function () {
			      $('#qLoverlay').remove();
			      $('body .item-load').remove();
			   },
        backgroundColor: "#a19173",
        barColor: "#a19173",
        barHeight: 1,
        percentage: true,
        deepSearch: true,
        completeAnimation: "fade",
        minimumTime: 500,
        onLoadComplete: function () {
            if (qLoptions.completeAnimation == "grow") {
                var animationTime = 100;
                var currentTime = new Date();
                if ((currentTime.getTime() - qLstart) < qLoptions.minimumTime) {
                    animationTime = (qLoptions.minimumTime - (currentTime.getTime() - qLstart));
                }

                 $('.line').stop().animate({  "width": "100%"}, animationTime, function () {
					       //$('.line').css({'width':'100%'});  
						  $('#qLoverlay').fadeOut(200, function () {      
						         qLoptions.onComplete();
								    Touch();
								 
                          });
                });
			}
		}
            
    };
	
	      
    var afterEach = function () {
        //start timer
        var currentTime = new Date();
        qLstart = currentTime.getTime();

        createPreloadContainer();
        createOverlayLoader();
    };

    var createPreloadContainer = function() {
         qLimageContainer = $('<div class="item-load"></div>').appendTo("body").css({
            display: "none",
            width: 0,
            height: 0,
            overflow: "hidden"
        });
        for (var i = 0; qLimages.length > i; i++) {
            $.ajax({
                url: qLimages[i],
                type: 'HEAD',
                success: function(data) {
                    if(!qLdestroyed){
                        qLimageCounter++;
                        addImageForPreload(this['url']);
                    }
                }
            });
        }
    };

    var addImageForPreload = function(url) {
        var image = $("<img />").attr("src", url).bind("load", function () {
            completeImageLoading();
        }).appendTo(qLimageContainer);
    };

    var completeImageLoading = function () {
        qLdone++;

        var percentage = (qLdone / qLimageCounter) * 100;
        $(qLbar).stop().animate({
            width: percentage + "%",
            minWidth: percentage + "%"
        }, 200);

        if (qLoptions.percentage == true) {
            $(qLpercentage).text(Math.ceil(percentage) + "%");
        }

        if (qLdone == qLimageCounter) {
            destroyQueryLoader();
        }
    };

    var destroyQueryLoader = function () {
        $(qLimageContainer).remove();
        qLoptions.onLoadComplete();
        qLdestroyed = true;
    };

    var createOverlayLoader = function () {
            qLoverlay = $('<div id="qLoverlay"></div>').css({
            width: "100%",
            height: "74px",
           // backgroundColor: qLoptions.backgroundColor,
            //backgroundPosition: "fixed",
            position: "absolute",

            zIndex: 1500,
            top: 0,
            left: 0,
        }).appendTo("body");
        qLbar = $('<div id="qLbar"></div>').css({
            height: qLoptions.barHeight + "px",
           // marginTop: "-" + (qLoptions.barHeight / 2) + "px",
            backgroundColor: qLoptions.barColor,
            width: "0%",
            position: "absolute",
            top: "0px"
        }).appendTo(qLoverlay);
        if (qLoptions.percentage == true) {
            qLpercentage = $('<div id="qLpercentage"></div>').text("0%").css({
               height: "120px",
			   width: "120px",
			   position: "absolute",
			   fontSize: "0px",
			   top: "50%",
			   left: "50%",
			//marginTop: "-" + (59 + this.parent.options.barHeight) + "px",
			   marginTop: "60px" ,
			   textAlign: "center",
			   marginLeft: "-60px",
			   color: "#fff"
            }).appendTo(qLoverlay);
        }
    };

    var findImageInElement = function (element) {
        var url = "";

        if ($(element).css("background-image") != "none") {
            var url = $(element).css("background-image");
        } else if (typeof($(element).attr("src")) != "undefined" && element.nodeName.toLowerCase() == "img") {
            var url = $(element).attr("src");
        }

        if (url.indexOf("gradient") == -1) {
            url = url.replace(/url\(\"/g, "");
            url = url.replace(/url\(/g, "");
            url = url.replace(/\"\)/g, "");
            url = url.replace(/\)/g, "");

            var urls = url.split(", ");

            for (var i = 0; i < urls.length; i++) {
                if (urls[i].length > 0 && qLimages.indexOf(urls[i]) == -1) {
                    var extra = "";
                    qLimages.push(urls[i] + extra);
                }
            }
        }
    }

    $.fn.queryLoader = function(options) {
        if(options) {
            $.extend(qLoptions, options );
        }

        this.each(function() {
            findImageInElement(this);
            if (qLoptions.deepSearch == true) {
                $(this).find("*:not(script)").each(function() {
                    findImageInElement(this);
                });
            }
        });

        afterEach();

        return this;
    };

})(jQuery);




