(function($) {
    var methods = {on: $.fn.on, bind: $.fn.bind};
    $.each(methods, function(k) {
        $.fn[k] = function() {
            var args = [].slice.call(arguments),
                    delay = args.pop(),
                    fn = args.pop(),
                    timer;
            args.push(function() {
                var self = this,
                        arg = arguments;
                clearTimeout(timer);
                timer = setTimeout(function() {
                    fn.apply(self, [].slice.call(arg));
                }, delay);
            });
            return methods[k].apply(this, isNaN(delay) ? arguments : args);
        };
    });
}(jQuery));



var Click;
var News;
var shownews;
var show;
var Scroll;
var Menu = 0;
var Menu2 = 0;
var Menu3 = 0;
var Details = 0;


function NavClick(Menu, Menu2, Menu3) {

    $('.sub-nav li a, .nav li a, .overlay-menu').click(function() {
        if ($(window).width() <= 1100) {
            Menu = 0;
            Menu2 = 0;
            Menu3 = 0;
            $('.navigation').css({'width': 0});
            $('.sub-nav, .sub-list').css({'height': 0});
            $('.right').hide();
            $('.nav-click, .nav-option, .sub-click').removeClass('active');
            $('.overlay-menu').css({'display': 'none'});
        }
    });

    $('.nav-click').bind('click', function() {

        if (Menu2 == 1) {
            $('.right').hide();
            Menu2 = 0;
            $('.nav-option').removeClass('active');
        } else if (Menu3 == 1) {
            $('.sub-nav, .sub-list').css({'height': 0});
            Menu3 = 0;
            $('.sub-click').removeClass('active');
        }

        if (Menu == 1) {
            Menu = 0;
            $('.navigation').css({'width': 0});
            $('.nav-click').removeClass('active');
            $('.overlay-menu').css({'display': 'none'});
        } else {
            Menu = 1;
            $('.navigation').css({'width': 200});
            $('.nav-click').addClass('active');
            $('.overlay-menu').css({'display': 'block'});

        }
        return false;
    });


    $('.nav-option').bind('click', function() {

        if (Menu == 1) {
            $('.navigation').css({'width': 0});
            Menu = 0;
            $('.nav-click').removeClass('active');
        } else if (Menu3 == 1) {
            $('.sub-nav, .sub-list').css({'height': 0});
            Menu3 = 0;
            $('.sub-click').removeClass('active');
        }

        if (Menu2 == 1) {
            Menu2 = 0;
            $('.right').hide();
            $('.nav-option').removeClass('active');
            $('.overlay-menu').css({'display': 'none'});
        } else {
            Menu2 = 1;
            $('.right').show();
            $('.nav-option').addClass('active');
            $('.overlay-menu').css({'display': 'block'});

        }
        return false;
    });

    $('.sub-click').bind('click', function() {

        if (Menu == 1) {
            $('.navigation').css({'width': 0});
            Menu = 0;
            $('.nav-click').removeClass('active');
        } else if (Menu2 == 1) {
            $('.right').hide();
            Menu2 = 0;
            $('.nav-option').removeClass('active');
        }

        if (Menu3 == 1) {
            Menu3 = 0;
            $('.sub-click').removeClass('active');
            $('.sub-nav, .sub-list').css({'height': 0});
            $('.overlay-menu').css({'display': 'none'});
        } else {
            Menu3 = 1;
            $('.sub-click').addClass('active');
            $('.sub-nav, .sub-list').css({'height': 300});
            $('.overlay-menu').css({'display': 'block'});
        }
        return false;
    });



}


function changeUrl(url, title, description, keyword, dataName, titleog, descriptionog) {
    if (window.history.pushState !== undefined) {
        var c_href = document.URL;
        if (c_href != url)
            window.history.pushState({path: url, dataName: dataName, title: title, keyword: keyword, description: description, titleog: titleog, descriptionog: descriptionog}, "", url);
    }
    if (title != '') {
        $('#hdtitle').html(title);
        $('meta[property="og:description"]').remove();
        $('#hdtitle').after('<meta property="og:description" content="' + descriptionog + '">');
        $('meta[property="og:title"]').remove();
        $('#hdtitle').after('<meta property="og:title" content="' + titleog + '">');
        $('meta[property="og:url"]').remove();
        $('#hdtitle').after('<meta property="og:url" content="' + url + '">');
        $('meta[name=keywords]').remove();
        $('#hdtitle').after('<meta name="keywords" content="' + keyword + '">');
        $('meta[name=description]').remove();
        $('#hdtitle').after('<meta name="description" content="' + description + '">');
    }
    $('#changlanguage_redirect').val(url);
}


function execSearch() {
    var qsearch = $('#qsearch').val();
    var href_search = $('#href_search').val();
    var defaultvalue = $('#defaultvalue').val();

    if (qsearch == defaultvalue)
        return false;
    if (qsearch != '') {
        var url = href_search + '?qsearch=' + encodeURIComponent(qsearch)

        window.location = url;
        return false;
    }
}


function Search() {
    $('.search').bind('click', function() {
        if (show == 1) {
            $('.search-form').css({'width': 0});
            $('.search').removeClass('active');
            show = 0;
			execSearch();
        } else {
            $('.search-form').css({'width': 220});
            $('.search').addClass('active');
            document.getElementById("search").reset();
            show = 1;
        }
    });
	
	$('#qsearch').keydown(function(e) {
        if (e.keyCode == 13) {
            execSearch();
        }
    });

}
function NewsClick(shownews) {
    if (News == 1) {
        $('.list-icon').click(function() {
            $('.news-right').css({'left': 0, 'right': 'auto'});
            $('.list-close').css({'display': 'block'});
            $('.list-icon').css({'display': 'none'});
            shownews = 1;
            return false;
        });

        $('.list-close').click(function() {
            $('.list-close').css({'display': 'none'});
            $('.list-icon').css({'display': 'block'});
            $('.news-right').css({'left': -256, 'right': 'auto'});
            shownews = 0;
            return false;
        });
    }

}

function NewsLoad(url) {
    $('.colum-box-news').append('<div class="loadicon" style="display:block"></div>');
    $.ajax({url: url, cache: false, success: function(data) {
            $('.news-tab').append(data);
            if ($('.news-tab .detail-news').length > 1) {
                $('.news-tab .detail-news').last().remove();
            }

            $('.news-tab').animate({'opacity': 1}, 600, 'linear', function() {
                ResizeWindows();
                if ($(window).width() > 1100) {
                    if ($('.scrollD').length) {
                        setTimeout(ScrollNiceD, 100);
                    } else {
                        setTimeout(ScrollNiceE, 100);
                    }
                } else {
                    shownews = 0;
                    NewsClick(shownews);
                    if ($('.news-list li').length > 1) {
                        setTimeout(ScrollList, 100);
                    }
                }

            });



            $('.loadicon').fadeOut(300, 'linear', function() {
                $('.loadicon').remove();
            });

            if ($(window).width() > 1100) {
                if ($('.news-list li .link-page.current').length == 0) {
                    $('.news-list li .link-page').first().addClass('current');
                    $('.news-nav li:first-child a').trigger('click');
                } else {
                    var index = $('.news-list ul li').index($('.news-list ul li div.current').parent());
                    $('.news-nav li:nth-child(' + 0 + [index + 1] + ') a').trigger('click');
                }

            }

        }
    });
}

function LoadContent(url) {
    $('.recruitment-box').append('<div class="loadicon" style="display:block"></div>');
    $.ajax({url: url, cache: false, success: function(data) {
            $('.scrollG').append(data);

            if ($('.scrollG .detail-recruitment').length > 1) {
                $('.scrollG .detail-recruitment').last().remove();
            }

           $('.sub-nav li:last-child().current a').css({'pointer-events': 'auto', 'cursor': 'pointer'});
		   
            $('.load-page').fadeIn(500, 'linear', function() {
                setTimeout(ScrollNiceG, 100);
                $('.recruitment-download').fadeIn(300, 'linear');
                $('.loadicon').fadeOut(300, 'linear', function() {
                    $('.loadicon').remove();
                });
            });


            $('.back').click(function() {
                ScrollNiceHide();
				$('.sub-nav li:last-child().current a').css({'pointer-events': 'none', 'cursor': 'default'});
                $('.recruitment-download').fadeOut(300, 'linear');
                $('.load-page').fadeOut(500, 'linear', function() {
                    $('.scrollG .detail-recruitment').remove();
                    $('.recruitment-slide').fadeIn(500, 'linear', function() {
                        setTimeout(ScrollNiceF, 100);
                    });

                });
				
				 
				var tmpurl = $(this).attr('data-href');
				var tmptitle = $(this).attr('data-title');
				 var tmpkeyword = $(this).attr('data-keyword');
				 var tmpdescription = $(this).attr('data-description');
				 
				 changeUrl(tmpurl,tmptitle,tmpdescription,tmpkeyword,'','','');
				 
                return false;
             });
			 
			 
			
			    $('.sub-nav li:last-child().current a').click(function(e) {
					$('.sub-nav li:last-child().current a').css({'pointer-events': 'none', 'cursor': 'default'});
					 e.preventDefault();
					 $('.back').trigger('click');
					 return false;
				 });


        }
    });
}


function VideoLoad(idx) {
    $.ajax({url: idx, cache: false, success: function(data) {
            $('.allvideo').append(data);
            $('.allvideo').css({'width': '100%', 'display': 'block'});
            $('.overlay-video').fadeIn(500, 'linear');
            var ThisVideo = document.getElementById("angia-video");
            function playVid() {
                ThisVideo.play();
            }
            function pauseVid() {
                ThisVideo.pause();
            }
            if ($('.slide-full').length && $('.bg').length > 1) {
                $('.slide-full').cycle('pause');
            }
            var lend = $('#angia-video').length;
            $('.close-video').click(function() {
                if (lend != 0) {
                    pauseVid();
                }
                var Top = $('.viewvideo').offset().top;
                View = 0;
                if ($('#home-page').length) {
                    if ($('.slide-full').length && $('.bg').length > 1) {
                        $('.slide-full').cycle('resume');
                    }

                }
                $('.video-list, .video-skin').fadeOut(500, 'linear', function() {
                    $('.close-video').fadeOut(300, 'linear');
                    $('.overlay-video').fadeOut(500, 'linear', function() {
                        $('.allvideo').css({'width': 0, 'display': 'none'});
                        $('.allvideo .video-list').remove();
                        if ($(window).width() <= 1100) {

                            ResizeWindows();
                            $('html, body').animate({scrollTop: Top}, 'slow');
                            $('div .viewvideo').removeClass('viewvideo');

                        }
                    });
                });
            });
        }
    });
}




function  Albumm() {
    if ($('.album-pic-center').length > 1) {
        $('.slide-pic-nav').css({'display': 'block'});
    }

    $('.album-center').cycle({fx: 'scrollHorz', timeout: 0, containerResize: 0, slideResize: 0, fit: 1, next: '.next-pic', prev: '.prev-pic',
        after: function() {
            TouchAlbum();
        },
        before: function(el, next_el) {
            $(el).removeClass('highlight');
            $(next_el).addClass('highlight');
            Before();
        }
    });

    function  Before() {
        if ($('.album-pic-center:last').hasClass('highlight')) {
            $('.next-pic').css({'display': 'none'});
        } else {
            $('.next-pic').css({'display': 'block'});
        }

        if ($('.album-pic-center:first').hasClass('highlight')) {
            $('.prev-pic').css({'display': 'none'});
        } else {
            $('.prev-pic').css({'display': 'block'});
        }

    }



    function TouchAlbum() {
        $('.album-center').swipe({
            swipeLeft: function(event, direction, distance, duration, fingerCount) {

                if ($('.album-pic-center:last').hasClass('highlight')) {
                    $('.next-pic').css({'display': 'none'});
                } else {
                    $('.next-pic').css({'display': 'block'});
                    $('.next-pic').trigger('click');
                }

            },
            swipeRight: function(event, direction, distance, duration, fingerCount) {

                if ($('.album-pic-center:first').hasClass('highlight')) {
                    $('.prev-pic').css({'display': 'none'});
                } else {
                    $('.prev-pic').css({'display': 'block'});
                    $('.prev-pic').trigger('click');
                }

            },
            threshold: 0,
            fingers: 'all'
        });
    }

    $('.album-center').stop().animate({'opacity': 1}, 600, 'linear');


}

function AlbumLoad(url) {
    $.ajax({url: url, cache: false, success: function(data) {
            $('.all-album').append(data);
            Albumm();

            $('.album-load').fadeIn(800, 'linear', function() {
                $('.loadicon').fadeOut(300, 'linear', function() {
                    $('.loadicon').remove();
                });
            });


            $('.close-album').click(function() {
                var Top = $('.viewalbum').offset().top;
                View = 0;
                $('.all-album').fadeOut(500, 'linear', function() {
                    $('.album-load').remove();
                });
                $('.overlay-album').delay(500).animate({'top': '-100%'}, 600, 'easeOutExpo', function() {
                    $('.overlay-album').css({'display': 'none'});
                    if ($(window).width() <= 1100) {

                        ResizeWindows();
                        $('html, body').animate({scrollTop: Top}, 'slow');
                        $('div .viewalbum').removeClass('viewalbum');
                    }
                });

                return false;
            });

        }
    });
}


function FadePic() {

    if ($('.slide-full').length) {
        var Time = $('.slide-full').attr('data-time');
        if ($('.bg').length > 1) {
            $('.next-prev').fadeIn(500, 'linear');
        } else {
            $('.next-prev').fadeOut(100, 'linear');
        }
        NumSlide = 1;

        $('.slide-full').cycle({fx: 'fade', timeout: Time, containerResize: 0, slideResize: 0, fit: 1, next: '.nextslide', prev: '.prevslide',
            after: function(el, next_el) {
                $(next_el).addClass('active');
                onBefore();
            },
            before: function(el) {
                $(el).removeClass('active');
                onAfter();
            }
        });

        $('.slide-full').swipe({
            swipeLeft: function(event, direction, distance, duration, fingerCount) {
                $('.nextslide').trigger('click');
            },
            swipeRight: function(event, direction, distance, duration, fingerCount) {
                $('.prevslide').trigger('click');
            },
            threshold: 0,
            fingers: 'all'
        });

    }

    function onBefore() {
        $('.bg.active').find('.slogan').stop().animate({'opacity': 1}, 800, 'linear');
    }

    function onAfter() {
        $('.bg .slogan').stop().animate({'opacity': 0}, 500, 'linear');
    }

    $('.bg-page').stop().animate({'opacity': 1}, 600, 'linear');
    $('.home-content').delay(600).animate({'opacity': 1}, 500, 'linear');

}


function FadePicture() {

if ($('.pic-right img').length>1) {
 $('.pic-right').cycle({fx: 'fade', timeout: 5000, containerResize: 0, slideResize: 0, fit: 1});
}

 $('.pic-right').stop().animate({'opacity': 1}, 600, 'linear');
    

}

function FocusText() {
    var txtholder = 'Họ Và Tên (*) HỌ VÀ TÊN (*) HỌ TÊN (*) Họ Tên (*)  Địa Chỉ (*) ĐỊA CHỈ (*) Điện Thoại (*) ĐIỆN THOẠI (*) Email (*) Yêu Cầu (*) YÊU CẦU (*) Request (*) REQUEST (*) Full Name (*) FULL NAME (*)  Address (*) ADDRESS (*) Phone (*) PHONE (*) EMAIL (*) User Name Password Công Ty Company Search... Tìm nhanh... Other Khác';
    var txtRep = "";
    $('input').focus(function() {
        txtRep = $(this).val();
        if (txtholder.indexOf(txtRep) >= 0) {
            $(this).val("");
        }
    });
    $('input').focusout(function() {
        if ($(this).val() == "")
            $(this).val(txtRep);
    });
    var cur_text = "";
    $('textarea').focus(function() {
        cur_text = $(this).val();
        if (cur_text == 'Ý Kiến (*)' || cur_text == 'Comments (*)' || cur_text == 'Nội Dung (*)' || cur_text == 'Content (*)')
            ;
        $(this).val('')
    }).focusout(function() {
        if ($(this).val() == "")
            $(this).val(cur_text)
    });


}


function ScrollNiceA() {
    if (isTouchDevice && isChrome) {
        $('.select .scrollA').getNiceScroll().show();
        $('.select .scrollA').niceScroll({touchbehavior: false, horizrailenabled: false, cursordragontouch:true});
        $('.select .scrollA').animate({scrollTop: "0px"});
    } else {
        $('.select .scrollA').getNiceScroll().show();
        $('.select .scrollA').niceScroll({touchbehavior: true, horizrailenabled: false, cursordragontouch:true});
        $('.select .scrollA').animate({scrollTop: "0px"});
    }
}
function ScrollNiceB() {
    if (isTouchDevice && isChrome) {
        $('.scrollB').getNiceScroll().show();
        $('.scrollB').niceScroll({touchbehavior: false, horizrailenabled: false, cursordragontouch:true});
        $('.scrollB').animate({scrollTop: "0px"});
    } else {
        $('.scrollB').getNiceScroll().show();
        $('.scrollB').niceScroll({touchbehavior: true, horizrailenabled: false, cursordragontouch:true});
        $('.scrollB').animate({scrollTop: "0px"});
    }
}
function ScrollNiceC() {
    if (isTouchDevice && isChrome) {
        $('.scrollC').getNiceScroll().show();
        $('.scrollC').niceScroll({touchbehavior: false, horizrailenabled: false, cursordragontouch:true});
        $('.scrollC').animate({scrollTop: "0px"});
    } else {
        $('.scrollC').getNiceScroll().show();
        $('.scrollC').niceScroll({touchbehavior: true, horizrailenabled: false, cursordragontouch:true});
        $('.scrollC').animate({scrollTop: "0px"});
    }
}
function ScrollNiceD() {
    if (isTouchDevice && isChrome) {
        $('.scrollD').getNiceScroll().show();
        $('.scrollD').niceScroll({touchbehavior: false, horizrailenabled: false, cursordragontouch:true});
        $('.scrollD').animate({scrollTop: "0px"});
    } else {
        $('.scrollD').getNiceScroll().show();
        $('.scrollD').niceScroll({touchbehavior: true, horizrailenabled: false, cursordragontouch:true});
        $('.scrollD').animate({scrollTop: "0px"});
    }
}
function ScrollNiceE() {
    if (isTouchDevice && isChrome) {
        $('.scrollE').getNiceScroll().show();
        $('.scrollE').niceScroll({touchbehavior: false, horizrailenabled: false, cursordragontouch:true});
        $('.scrollE').animate({scrollTop: "0px"});
    } else {
        $('.scrollE').getNiceScroll().show();
        $('.scrollE').niceScroll({touchbehavior: true, horizrailenabled: false, cursordragontouch:true});
        $('.scrollE').animate({scrollTop: "0px"});
    }
}
function ScrollNiceF() {
    if (isTouchDevice && isChrome) {
        $('.scrollF').getNiceScroll().show();
        $('.scrollF').niceScroll({touchbehavior: false, horizrailenabled: false, cursordragontouch:true});
        $('.scrollF').animate({scrollTop: "0px"});
    } else {
        $('.scrollF').getNiceScroll().show();
        $('.scrollF').niceScroll({touchbehavior: true, horizrailenabled: false, cursordragontouch:true});
        $('.scrollF').animate({scrollTop: "0px"});
    }
}
function ScrollNiceG() {
    if (isTouchDevice && isChrome) {
        $('.scrollG').getNiceScroll().show();
        $('.scrollG').niceScroll({touchbehavior: false, horizrailenabled: false, cursordragontouch:true});
        $('.scrollG').animate({scrollTop: "0px"});
    } else {
        $('.scrollG').getNiceScroll().show();
        $('.scrollG').niceScroll({touchbehavior: true, horizrailenabled: false, cursordragontouch:true});
        $('.scrollG').animate({scrollTop: "0px"});
    }
}
function ScrollList() {
    $('.scroll-list').css({'overflow-x':'hidden','overflow-y':'auto', '-webkit-overflow-scrolling':'touch'});	
}
function ScrollNiceHide() {
    $('.scrollA, .scrollB, .scrollC, .scrollD, .scrollE, .scrollF, .scrollG').getNiceScroll().remove();
}



function LinkPage() {
    $('.language li a, .nav li a, .more-detail, a.details, .go-back a, .go-back-top a, a.view-details').click(function(e) {
        e.preventDefault();
        linkLocation = $(this).attr("href");
        ScrollNiceHide();
        $('.line').css({'width': 0});
        var OutBg = $('.bg-page, .overlay-menu');
        var OutCenter = $('.container');
        $(OutBg).animate({'opacity': 0}, 300, 'linear');
        $(OutCenter).animate({'opacity': 0}, 500, 'linear', function() {

            window.location = linkLocation;
        });


        return false;
    });



}


function ContentLoad() {
    ResizeWindows();
    LinkPage();
    Search();
    FocusText();

    //HOME PAGE//
    if ($('#home-page').length) {
		
        $('.nav li:nth-child(1)').addClass('current');
        FadePic();
        Option();

        if ($('.popup-pics').length) {
            $('.slide-full').cycle('pause');
        } else {
            $('.slide-full').cycle('resume');
        }
		
        if ($('.popup-pics img').length > 0) {
            $('.popup-pics').append('<div class="close-popup"><span class="hover"></span></div>');
            $('.overlay-dark').fadeIn(500, 'linear', function() {
                $('.popup-pics').fadeIn(500, 'linear');
                $('body').removeClass('first-time');
            });

            $('.close-popup, .overlay-dark').click(function() {
                $('.slide-full').cycle('resume');
                $('.popup-pics, .overlay-dark').fadeOut(500, 'linear', function() {
                    $('.close-pics').remove();
                });
                return false;
            });

        }



    }



    //ABOUT PAGE//
    if ($('#about-page').length) {
		Animation();
        Option();
        FadePic();
		FadePicture();
        //Touch();

        if ($(window).width() > 1100) {
            if ($('.sub-nav ul li.current').length) {
                $('.sub-nav ul li.current a').trigger('click');
            } else {
                $('.sub-nav li:first-child a').trigger('click');
            }
        } else {
            ResizeWindows();
        }

    }


    //PROJECTS PAGE//
    if ($('#projects-page').length) {
        if ($('.sub-nav li').length > 1) {
            $('.next-prev-2').fadeIn(100, 'linear');
        } else {
            $('.next-prev-2').fadeOut(100, 'linear');
        }
        Animation();
        Option();
        FadePic();
        Touch();


        if ($(window).width() > 1100) {
            if ($('.sub-nav ul li.current').length) {
                $('.sub-nav ul li.current a').trigger('click');
            } else {
                $('.sub-nav li:first-child a').trigger('click');
            }
        } else {
            ResizeWindows();
        }

    }


    //PROJECT DETAILS PAGE//
    if ($('#project-details-page').length) {
		$('.nav li.current a').css({'pointer-events': 'auto', 'cursor': 'pointer'});

        if ($('.slide-nav li').length > 1) {
            $('.next-prev-3').fadeIn(100, 'linear');
        } else {
            $('.next-prev-3').fadeOut(100, 'linear');
        }

        $('.slide-nav li a').click(function(e) {
            e.preventDefault();


            var allItem2 = $('.house-detail').length;
            var widthItem2 = $('.house-detail').width() + 100;
            $('.box-house').width(allItem2 * widthItem2);

            $('.slide-nav li').removeClass('current');
            $('.house-detail').removeClass('active');
            $(this).parent().addClass('current');
            var OpenPage = $(this).attr('data-target');

            detectBut();
            var XCurrent = $('.house-detail').offset().left;
            var XItem = $('.box-house .house-detail[data-pos= "' + OpenPage + '"]').offset().left;

            $('.box-house').stop().animate({'left': XCurrent - XItem}, 'slow', function() {
                $('.house-detail[data-pos= "' + OpenPage + '"]').addClass('active');
            });

            return false;
        });

        $('.prev').click(function() {
            $('.slide-nav li.current').prev().find('a').trigger('click');
            return false;
        });

        $('.next').click(function() {
            $('.slide-nav li.current').next().find('a').trigger('click');
            return false;
        });

        $('.slide-nav li:first-child a').trigger('click');

        //SHOW NEWS DETAILS// 
        $('.news-list li .link-page a').click(function(e) {
            e.preventDefault();
            $('.news-list li .link-page').removeClass('current');
            $(this).parent().addClass('current');
            var Detail = $(this).attr("data-details");
            var url = $(this).attr('href')
            if ($(window).width() > 1100) {
                //window.location.hash = Detail;
				var tmpurl = $(this).attr('href');
				var tmptitle = $(this).attr('data-title');
				 var tmpkeyword = $(this).attr('data-keyword');
				 var tmpdescription = $(this).attr('data-description');
				 var tmpdataname = $(this).attr('data-name');
				 changeUrl(tmpurl,tmptitle,tmpdescription,tmpkeyword,tmpdataname,'','');
            }

            $(".news-tab").stop().animate({'opacity': 0}, 600, 'linear', function() {
                ScrollNiceHide();
                $('.news-tab  .detail-news').remove();
                NewsLoad(url);
            });

            return false;
        });


        Animation();
        Option();
        FadePic();
        Touch();

        if ($(window).width() > 1100) {

            if($('.news-list li .link-page.current').length) {
                $('.news-list li .link-page.current').find('a').trigger('click');
            }else{
                $('.news-list li:first-child .link-page:first-child').find('a').trigger('click');
            }
            if ($('.sub-nav ul li.current').length) {
                $('.sub-nav ul li.current a').trigger('click');
            } else {
                $('.sub-nav li:first-child a').trigger('click');
            }

        } else {
            $('.news-list li:first-child .link-page').find('a').trigger('click');
            ResizeWindows();
        }

    }

    //NEWS PAGE//
    if ($('#news-page').length) {
		$('.sub-list li a').click(function (e) {
				 e.preventDefault();
				  if ($(window).width() <= 1100) {
					  $('.overlay-menu').trigger('click');
					  $('html, body').animate({scrollTop: 0}, 'fast');
				   }else{
					   var tmpurl = $(this).attr('href');
						var tmptitle = $(this).attr('data-title');
						 var tmpkeyword = $(this).attr('data-keyword');
						 var tmpdescription = $(this).attr('data-description');
						 var tmpdataname = $(this).attr('data-name');
						 changeUrl(tmpurl,tmptitle,tmpdescription,tmpkeyword,tmpdataname,'','');
					  $('.scrollF').animate({scrollTop:"0px"});
				  }
				  
				  
				  
				 $('.news-all').append('<div class="loadicon" style="display:block"></div>');
				 $('.scrollE').animate({scrollTop:"0px"});
				 $('.sub-list li').removeClass('current');
				 $(this).parent().addClass('current');
				  ScrollNiceHide();
				 //$('.news-box').each(function(i){
					// var box = $(this);
					   //setTimeout(function(){$(box).css({ opacity:0});  $(box).hide()}, (i+2) * 30);
				  // });
				
				     $('.news-slide').stop().animate({'opacity': 0}, 600, 'linear', function () {
						$('.news-box').css({ 'opacity':0, 'display':'none'});
					 });
				  var Select = $(this).attr('data-target');
				  setTimeout(function(){ showList(Select) }, 800);
			   
			 return false;
		   
		   });   
		   
		   
		   
		function showList(Select){
		   if(Select == 'all'){
				$('.news-box').css({'display':"none"});
				$('.news-box').css({'display':"inline-block"});
				 $('.news-slide').css({ 'opacity':1});
				  $('.news-box').each(function(i){
					 var box = $(this);
					   setTimeout(function(){$(box).css({ opacity:1}); }, (i+1) * 100);
				   });
					   $('.loadicon').fadeOut(200, 'linear', function () {
						   $('.loadicon').remove();
						   
					   });
				   setTimeout(function() { ScrollNiceF(); }, 800);	 
			  
		   }else{
			   $('.news-box').css({'display':"none"});
			   $('.news-slide').css({ 'opacity':1});
			   $('.news-box[data-post= "' + Select + '"]').css({'display':"inline-block"});
			   $('.news-box[data-post= "' + Select + '"]').each(function(i){
					 var box = $(this);
					   setTimeout(function(){$(box).css({ opacity:1}); }, (i+1) * 100);
				   });
				  
					   $('.loadicon').fadeOut(200, 'linear', function () {
						   $('.loadicon').remove();
					   });
					   
					   setTimeout(function() { ScrollNiceF(); }, 800);
			   
			 }
			 
			}

			 if($('.sub-list li').length > 0){
				if($('.sub-list li.current').length)
					$('.sub-list li.current a').trigger('click');
				else
					$('.sub-list li:first-child a').trigger('click');
		   }else{
				 $('.news-box').each(function(i){
					 var box = $(this);
					 setTimeout(function(){$(box).css({ opacity:1}); }, (i+1) * 50);
				 });
		   }
 

        Option();
        FadePic();
       

      
    }

    //NEWS-DETAILS-PAGE//
    if ($('#news-details-page').length) {
		$('.nav li.current a').css({'pointer-events': 'auto', 'cursor': 'pointer'});

        $('.news-list li .link-page a').click(function(e) {
            e.preventDefault();
            $('.news-list li .link-page').removeClass('current');
            $(this).parent().addClass('current');
            var Detail = $(this).attr("data-details");
			var url = $(this).attr('href') 
			//window.location.hash = Detail;
			
           var url = $(this).attr('data-href');
			var tmpurl = $(this).attr('href');
			var tmptitle = $(this).attr('data-title');
			 var tmpkeyword = $(this).attr('data-keyword');
			 var tmpdescription = $(this).attr('data-description');
			 var tmpdataname = $(this).attr('data-name');
			 changeUrl(tmpurl,tmptitle,tmpdescription,tmpkeyword,tmpdataname,'','');
            
            $(".news-tab").stop().animate({'opacity': 0}, 600, 'linear', function() {
                ScrollNiceHide();
                $('.news-tab  .detail-news').remove();
                NewsLoad(url);
            });

            return false;
        });

        
           if($('.news-list li .link-page.current').length) {
                $('.news-list li .link-page.current').find('a').trigger('click');
             
            }else{
                $('.news-list li:first-child .link-page:first-child').find('a').trigger('click');
               
            }

        FadePic();
        Option();
    }
	
	//SEARCh-PAGE//
    if ($('#search-page').length) {
		$('.news-tab').animate({'opacity': 1}, 600, 'linear', function() {
			ResizeWindows();
			if ($(window).width() > 1100) {
				if ($('.scrollD').length) {
					setTimeout(ScrollNiceD, 100);
				} else {
					setTimeout(ScrollNiceE, 100);
				}
			} else {
				shownews = 0;
				NewsClick(shownews);
				if ($('.news-list li').length > 1) {
					setTimeout(ScrollList, 100);
				}
			}

		});
            
        FadePic();
        Option();
    }

    //RECRUITMENT PAGE//
    if ($('#recruitment-page').length) {
	    $('a.show-details').click(function(e) {
            e.preventDefault();
            ScrollNiceHide();
		    var url = $(this).attr('href');
			
            var url_c = $(this).attr('data-href');
            var name = $(this).attr('data-name');
			
			var tmpurl = $(this).attr('href');
			var tmptitle = $(this).attr('data-title');
			 var tmpkeyword = $(this).attr('data-keyword');
			 var tmpdescription = $(this).attr('data-description');
			 var tmpdataname = $(this).attr('data-name');
			 changeUrl(tmpurl,tmptitle,tmpdescription,tmpkeyword,tmpdataname,'','');
			 
            $('.recruitment-slide').fadeOut(500, 'linear', function() {
                LoadContent(url);
            });
            return false;
        });


        $('.load-page, .scrollG, .colum-box').mouseenter(function() {
            CheckBut();
        });

        Animation();
        Option();
        FadePic();

        if ($(window).width() > 1100) {
            
            if ($('.sub-nav ul li.current').length) {
                $('.sub-nav ul li.current a').trigger('click');
            } else {
                $('.sub-nav li:first-child a').trigger('click');
            }
			if ($('.recruitment .show-details.current').length) {
                $('.recruitment .show-details.current').trigger('click');
            }
            
        } else {
            ResizeWindows();
        }

    }

    //CONTACT PAGE//
    if ($('#contact-page').length) {
        initialize();
        Option();
        FadePic();
    }


}

function Animation() {

    $('.sub-nav li a').click(function(e) {
        e.preventDefault();
		$('.sub-nav li a').css({'pointer-events': 'auto', 'cursor':'pointer'});
        if ($(window).width() > 1100) {
            var allItem = $('.colum-box').length;
            var widthItem = $('.colum-box').width() + 100;
            $('.box-content').width(allItem * widthItem);

            $('.sub-nav li').removeClass('current');
            $('.colum-box').removeClass('active');
            $('.about-box').removeClass('select');
            $('.illustrator').removeClass('fadeinup');


            $(this).parent().addClass('current');
			$('.sub-nav li.current a').css({'pointer-events': 'none', 'cursor': 'default'});
            var OpenPage = $(this).attr('data-open');

            $('.colum-box[id= "' + OpenPage + '"]').addClass('active');
            var url = $(this).attr('href');
            var Name = $(this).attr('data-name');
            if ($('.active .news-right .link-page.current').length > 0) {
                var SubName = $('.active .news-right .link-page.current a').attr('data-details');
				var tmpurl = $('.active .news-right .link-page.current a').attr('href');
                var tmptitle = $('.active .news-right .link-page.current a').attr('data-title');
				 var tmpkeyword = $('.active .news-right .link-page.current a').attr('data-keyword');
				 var tmpdescription = $('.active .news-right .link-page.current a').attr('data-description');
				 var tmpdataname = $('.active .news-right .link-page.current a').attr('data-name');
				 changeUrl(tmpurl,tmptitle,tmpdescription,tmpkeyword,tmpdataname,'','');

            } else {
                var Name = $(this).attr('data-name');
                var tmpurl = $(this).attr('href');
                var tmptitle = $(this).attr('data-title');
				 var tmpkeyword = $(this).attr('data-keyword');
				 var tmpdescription = $(this).attr('data-description');
				 var tmpdataname = $(this).attr('data-name');
				 changeUrl(tmpurl,tmptitle,tmpdescription,tmpkeyword,tmpdataname,'','');

			}

            detectBut();


            var XCurrent = $('.box-content').offset().left;
            var XItem = $('.box-content .colum-box[id= "' + OpenPage + '"]').offset().left;
            $('.box-content').stop().animate({'left': XCurrent - XItem}, 600, 'easeInOutExpo', function() {
                $('.colum-box.active').find('.illustrator').addClass('fadeinup');
                $('.colum-box.active').find('.about-box').addClass('select');
                if ($('.scrollA, .scrollB,  .scrollC,  .scrollD,  .scrollE, .scrollF').length) {
                    setTimeout(function() {
                        ScrollNiceA();
                        ScrollNiceB();
                        ScrollNiceC();
                        ScrollNiceD();
                        ScrollNiceE();
                        ScrollNiceF();
                    }, 100);
                }
            });
        } else {

            $('.sub-nav li').removeClass('current');
            $('.colum-box').removeClass('active');
            $(this).parent().addClass('current');
            var OpenPage = $(this).attr('data-open');
            var YItem = $('.box-content .colum-box[id= "' + OpenPage + '"]').offset().top;
            $('html, body').stop().animate({scrollTop: YItem}, 600, 'easeInOutExpo', function() {
                $('.colum-box[id= "' + OpenPage + '"]').addClass('active');
            });

        }

        return false;
    })

    if ($('#projects-page, #news-page').length) {
        $('.container').mousewheel(function(e, delta) {
            if ($(window).width() > 1100) {
                if (delta > 0) {
                    $('.sub-nav li.current').prev().find('a').trigger('click');
                    return false;
                } else {
                    $('.sub-nav li.current').next().find('a').trigger('click');
                    return false;
                }
            }
        });
    }



    $('.prevslide').click(function() {
        $('.sub-nav li.current').prev().find('a').trigger('click');
        return false;
    });

    $('.nextslide').click(function() {
        $('.sub-nav li.current').next().find('a').trigger('click');
        return false;
    });


}



function Option() {

    $('.all-link li a').on('click, mouseenter', function(e) {
        e.preventDefault();
        $('.news-home, .video-home, .number-home').fadeOut(50, 'linear');
        var Show = $(this).attr('data-name')
        $('.all-link li').removeClass('current');
        $(this).parent().addClass('current');
        $('div[data-post= "' + Show + '"]').fadeIn(600, 'linear', function() {
        });
        return false;
		
    });


    $('.news-home, .video-home, .video-home .block, .number-home, .number-home .block').mouseleave(function() {
        if ($(window).width() > 1100) {
            $('.news-home, .video-home, .number-home').fadeOut(300, 'linear');
            $('.all-link li').removeClass('current');
        }
    });
	
	
	
	$('.comment, .hidden-footer').mouseenter(function() {
        if ($(window).width() > 1100) {
            $('.news-home, .video-home, .number-home').fadeOut(300, 'linear');
            $('.all-link li').removeClass('current');
        }
    });
	
	


	

    $('a.player').click(function(e) {
        e.preventDefault();
        $(this).parent().addClass('viewvideo');
        if ($(window).width() <= 1100) {
            $('html, body').animate({scrollTop: 0}, 'slow');
            $('body').css({'overflow': 'hidden'});
            $('.overlay-dark').css({'overflow': 'hidden', 'width': $(window).width()});
            View = 1;
            ResizeWindows();
        }
        var idx = $(this).attr('data-href');
        VideoLoad(idx);
        return false;
    });


    $('.view-album').click(function(e) {
        e.preventDefault();
        $(this).parent().addClass('viewalbum');
        var url = $(this).attr('data-href');
        $('.all-album').append('<div class="loadicon" style="display:block"></div>');
        $('.all-album').fadeIn(100, 'linear');
        if ($(window).width() <= 1100) {
            $('html, body').animate({scrollTop: 0}, 'slow');
            $('.overlay-album').css({'top': '0%'});
            $('.overlay-album').fadeIn(500, 'linear', function() {
                $('body').css({'overflow': 'hidden'});
                $('.overlay-album').css({'overflow': 'hidden', 'width': $(window).width()});
                View = 1;
                AlbumLoad(url);
                ResizeWindows();

            });
        } else {
            $('.overlay-album').css({'display': 'block'});
            $('.overlay-album').animate({'top': '0%'}, 800, 'easeOutExpo', function() {
                AlbumLoad(url);
            });
        }

        return false;
    });

    $('.news-nav li a').click(function() {
        var allIX = $('.news-list li').length;
        var widthItemX = $('.news-list li').width() + 5;
        $('.news-list ul').width(allIX * widthItemX);
        $('.news-list ul').css({'height': 335});
        $('span.start').css({'opacity': 0});
        $('.news-nav li').removeClass('current');
        $('.news-list li').removeClass('active');
        $(this).parent().addClass('current');
        var Num = $(this).attr('data-list');
        $('.news-list li[data-number= "' + Num + '"]').addClass('active');
        var Current = Num;
        var XCurrent = $('.news-list ul').offset().left;
        var XItem = $('.news-list li[data-number= "' + Num + '"]').offset().left;
        detectBut();

        $('span.start').text(Current);
        if(allIX<10)
			$('span.end').text("0" + allIX);
		else
			$('span.end').text(allIX);
		
        $('.news-list ul').stop().animate({'left': XCurrent - XItem}, 300, 'linear');

        return false;
    });

    $('.prev-slide').click(function() {
        $('.news-nav li.current').prev().find('a').trigger('click');
        return false;
    });

    $('.next-slide').click(function() {
        $('.news-nav li.current').next().find('a').trigger('click');
        return false;
    });


    $('.zoom').click(function() {
        if ($(window).width() <= 1100) {
            $('html, body').animate({scrollTop: 0}, 'slow');
            $('body').css({'overflow': 'hidden'});
            View = 1;
            ResizeWindows();
        }
        $('.all-pics').css({'display': 'block'});
        $('.all-pics').append('<div class="full"></div>');
        $('.full').css({'width': $(window).width(), 'height': $(window).height()});
        $('.overlay-dark').fadeIn(300, 'linear');
        var activePicLarge = $(this).parent().find('img').attr("src");

        $('body').append('<div class="loadicon" style="display:block"></div>');
        $('body').append('<div class="close-pics" style="display:block"></div>');
        $('.all-pics').children().append('<img src ="' + (activePicLarge) + '" alt="pic" />');

        $('.full img').load(function() {
            $('.full').delay(300).fadeIn(400, 'linear', function() {
                $('.all-pics').css({'width': '100%'});

                var ImgW = $('.full img').width();
                var ImgH = $('.full img').height();
                var Yheight = $(window).height();
                var Xwidth = $(window).width();
                if ($(window).width() > 1100) {
                    if (Xwidth > ImgW) {
                        $('.full img').css({'margin-left': Xwidth / 2 - ImgW / 2});
                    } else {
                        $('.full img').css({'margin-left': 0});
                    }
                    if (Yheight > ImgH) {
                        $('.full img').css({'margin-top': Yheight / 2 - ImgH / 2});
                    } else {
                        $('.full img').css({'margin-top': 0});
                    }

                    if (isTouchDevice && isChrome) {
                        $('.full').getNiceScroll().show();
                        $('.full').niceScroll({touchbehavior: false, usetransition: true, hwacceleration: true, grabcursorenabled: true});
                        $('.full').animate({scrollTop: "0px"});
                    } else {
                        $('.full').getNiceScroll().show();
                        $('.full').niceScroll({touchbehavior: true, usetransition: true, hwacceleration: true, grabcursorenabled: true});
                        $('.full').animate({scrollTop: "0px"});
                    }
                }

                $('.full img').css({'opacity': 1});
                $('.loadicon').remove();
            });
        });

        $('.close-pics, .overlay-dark').click(function() {
            if ($(window).width() > 1100) {
                $('.full').getNiceScroll().remove();
            } else {
                View = 0;
                ResizeWindows();
                $('body').css({'overflow-x': 'hidden', 'overflow-y': 'auto'});
            }
            $('.full, .close-pics').fadeOut(300, 'linear');
            $('.overlay-dark').fadeOut(300, 'linear', function() {
                $('.all-pics .full').remove();
                $('.close-pics').remove();
                $('.all-pics').css({'width': 0, 'display': 'none'});
            });
        });
        return false;
    });



}

function CheckBut() {
    var textLength = $('#file-field').val();
    if (textLength == '') {
        $('a.send').fadeOut(300, 'linear');
    } else {
        $('a.send').fadeIn(300, 'linear');

    }
}
function detectBut() {
    if ($('.sub-nav li:first-child').hasClass('current')) {
        $('.prevslide').addClass('disable');
    } else {
        $('.prevslide').removeClass('disable');
    }
    if ($('.sub-nav li:last-child').hasClass('current')) {
        $('.nextslide').addClass('disable');
    } else {
        $('.nextslide').removeClass('disable');
    }

    if ($('.slide-nav li:first-child').hasClass('current')) {
        $('.prev').addClass('disable');
    } else {
        $('.prev').removeClass('disable');
    }
    if ($('.slide-nav li:last-child').hasClass('current')) {
        $('.next').addClass('disable');
    } else {
        $('.next').removeClass('disable');
    }


    if ($('.news-nav li:first-child').hasClass('current')) {
        $('.prev-slide').addClass('disable');
    } else {
        $('.prev-slide').removeClass('disable');
    }
    if ($('.news-nav li:last-child').hasClass('current')) {
        $('.next-slide').addClass('disable');
    } else {
        $('.next-slide').removeClass('disable');
    }

    $('span.start').css({'opacity': 1});






}
function Touch() {
    if ($(window).width() > 1100) {
        var Touch = $('.content-page');
      //  $(Touch).swipe({
//            swipeLeft: function(event, direction, distance, duration, fingerCount) {
//                if ($(window).width() > 1100) {
//                    $('.sub-nav li.current').next().find('a').trigger('click');
//                }
//            },
//            swipeRight: function(event, direction, distance, duration, fingerCount) {
//                if ($(window).width() > 1100) {
//                    $('.sub-nav li.current').prev().find('a').trigger('click');
//                }
//            },
//            threshold: 0,
//            fingers: 'all'
//        });

    } else {

        var TouchMobile = $('.box-house');
        $(TouchMobile).swipe({
            swipeLeft: function(event, direction, distance, duration, fingerCount) {
                if ($(window).width() < 1100) {
                    $('.slide-nav li.current').next().find('a').trigger('click');
                }
            },
            swipeRight: function(event, direction, distance, duration, fingerCount) {
                if ($(window).width() < 1100) {
                    $('.slide-nav li.current').prev().find('a').trigger('click');
                }
            },
            threshold: 0,
            fingers: 'all'
        });
    }

    if ($('.box-slide').length && $(window).width() > 1100) {
        var ImgW = $('.box-slide img').width();
        var Width = $('.box-slide').width();

        if (ImgW > Width + 50) {
            $('.go-right, .go-left').css({'display': 'block'});
        }
        if ($(window).width() > 1100) {
            $('.go-left').mouseover(function() {
                $('.box-slide img').stop().animate({'left': 0}, 3500, 'easeOutExpo');
                return false;
            });

            $('.go-right').mouseover(function() {
                $('.box-slide img').stop().animate({'left': Width - ImgW}, 3500, 'easeOutExpo');
                return false;
            });

            $('.go-right, .go-left').mouseleave(function() {
                $('.box-slide img').stop();
                return false;
            });

        }


    }
    

}



$(document).ready(function() {

    $(document).bind('scroll', function() {
        var windscroll = $(document).scrollTop();
        var HF = $('.bg-page').height();
        if ($(window).width() <= 1100 && Scroll == 1) {
            if (windscroll > 50) {
                $('.scroll-down').fadeOut(500, 'linear');
            } else {
                $('.scroll-down').fadeIn(500, 'linear');

            }
            if (windscroll > HF + 200) {
                $('.top').css({'top': windscroll});
                $('.sub-click').css({'top': windscroll - HF, 'margin-top': 125});
                if ($('#recruitment-page').length) {
                    $('.sub-nav').css({'top': windscroll - HF, 'margin-top': 115});
                } else {
                    $('.sub-nav, .sub-list').css({'top': windscroll - HF, 'margin-top': 15});
                }

                $('.logo').css({'display': 'none'});
                $('.nav-click, .sub-click, .nav-option').css({'opacity': 0.5});
            } else {
                $('.top').css({'top': 0});
                $('.sub-click').css({'top': 10, 'margin-top': 0});

                if ($('#recruitment-page').length) {
                    $('.sub-nav').css({'top': 0, 'margin-top': 0});
                } else {
                    $('.sub-nav, .sub-list').css({'top': -90, 'margin-top': 0});
                }

                $('.logo').css({'display': 'block'});
                $('.nav-click, .sub-click, .nav-option').css({'opacity': 1});

            }


            $('.colum-box').each(function() {
                var top = $(this).offset().top - HF;
                var bottom = top + $(this).outerHeight();

                if (windscroll >= top && windscroll <= bottom) {
                    $('.sub-nav li').removeClass('current');
                    $('.colum-box').removeClass('active');
                    $(this).addClass('active');
                    $('.sub-nav li').find('a[data-open="' + $(this).attr('id') + '"]').parent().addClass('current');

                }
            });

        }

    });


    $('.go-top').click(function() {
        $('html, body').animate({scrollTop: 0}, 'fast');
    });


    if ($(window).width() <= 1100) {
        $('html, body').animate({scrollTop: 0}, 'fast');
        NavClick(Menu, Menu2, Menu3);
    }

    if ($('#browser-hide').length) {
        document.getElementById("upload").reset();
    }

    $('#browser-hide').mouseenter(function() {
        $(this).parent().find('.browser-button').css({'opacity': 0.5});
        return false;
    });

    $('#browser-hide').mouseleave(function() {
        $(this).parent().find('.browser-button').css({'opacity': 1});
        return false;

    });

    $('a.send').click(function() {
        document.getElementById("upload").reset();
    });

    Done();
});





$(window).resize(function() {
    ScrollNiceHide();
    ResizeWindows();
    if ($('.box-slide').length) {
        $('.box-slide img').css({'left': 0});
    }
    $('.overlay-menu').css({'display': 'none'});
    $('.nav-option, .nav-click, .sub-click').removeClass('active');
    $('.go-top').css({'display': 'none'});
    $('.bottom-left a').removeClass('current');
    if ($('.slide-full').length) {
        $('.slide-full').cycle('pause');
    }
    if (shownews == 1) {
        $('.list-close').trigger('click');
    } else {
        NewsClick();
    }
});




$(window).on('resize', function() {
    if ($('.slide-full').length) {
        $('.slide-full').cycle('resume');
    }
    Touch();

    if ($(window).width() > 1100) {
        Open = 1;
		 if (IEMobile || isTouchIE || isIE11) {
		    $('body').getNiceScroll().hide();
		 }
        if ($('#about-page, #projects-page,  #project-details-page, #news-page, #recruitment-page').length) {
            $('.colum-box, .box-slide').removeClass('active');
            $('.about-box').removeClass('select');
            if ($('.sub-nav li').hasClass('current')) {
                $('.sub-nav li.current a').trigger('click');
            } else {
                $('.sub-nav li:first-child a').trigger('click');
            }

            if ($('.slide-nav li').hasClass('current')) {
                $('.slide-nav li.current a').trigger('click');
            } else {
                $('.slide-nav li:first-child a').trigger('click');
            }

            if ($('.news-list li .link-page.current').length == 0) {
                $('.news-list li .link-page').first().addClass('current');
                $('.news-nav li:first-child a').trigger('click');
            } else {
                var index = $('.news-list ul li').index($('.news-list ul li div.current').parent());
                $('.news-nav li:nth-child(' + 0 + [index + 1] + ') a').trigger('click');
            }

        }

        if ($('#news-details-page').length) {
            if ($('.news-list li .link-page.current').length == 0) {
                $('.news-list li .link-page').first().addClass('current');
                $('.news-nav li:first-child a').trigger('click');
            } else {
                var index = $('.news-list ul li').index($('.news-list ul li div.current').parent());
                $('.news-nav li:nth-child(' + 0 + [index + 1] + ') a').trigger('click');
            }
        }


        if ($('.scrollA, .scrollB,  .scrollC,  .scrollD,  .scrollE,  .scrollF,  .scrollG').length) {
            ScrollNiceA();
            ScrollNiceB();
            ScrollNiceC();
            ScrollNiceD();
            ScrollNiceE();
            ScrollNiceF();
            ScrollNiceG();
        }
        ResizeWindows();
    } else {
        $('.sub-nav li, .slide-nav li').removeClass('current');
        $('.slide-nav li:first-child').addClass('current');
        DoneLoad = 1;
        Open = 0;
        NavClick(Menu, Menu2, Menu3);
        ResizeWindows();
          if (IEMobile || isTouchIE || isIE11) {
		    $('body').getNiceScroll().show();
			$('body').getNiceScroll().resize();
		 }

        if ($('.news-list li .link-page.current').length == 0) {
            $('.news-list li .link-page').first().find('a').trigger('click');
        }

        if ($('.news-list li').length > 1) {
            setTimeout(ScrollList, 100);
        }

    }

    if ($('#contact-page').length) {
        initialize();
    }
}, 150);

$(window).bind("popstate", function(e) {
    e.preventDefault();
    LinkPage();
	var httpserver = $('.httpserver').text();
	
	if (e.originalEvent.state !== null) {
        ScrollNiceHide();
        var tmp_url = e.originalEvent.state.path;
        var tmp_dataName = e.originalEvent.state.dataName;
        var tmptitle = e.originalEvent.state.title;
		var tmpdescription = e.originalEvent.state.description;
		var tmpkeyword = e.originalEvent.state.keyword;
        var tmpurl = document.URL;

        changeUrl(tmp_url, tmptitle, tmpdescription, tmpkeyword, tmp_dataName, '', '');
		
		var temp_url = tmp_url.replace(httpserver, ""); 
		var tmp = temp_url.split('/');

        if ($('#about-page').length) {
			$(".sub-nav li a").each(function(index, element) {
				if ($(element).attr('href') == tmp_url) {
					$(element).trigger('click');
				}
			});
        }
		
		if ($('#recruitment-page').length) {
			if(tmp[2]!='' && tmp[2]!=undefined){
				$(".sub-nav li a").each(function(index, element) {
					if ($(element).attr('href') == httpserver +tmp[0] + '/' + tmp[1] + '.html') {
						$(element).trigger('click');
					}
					
					$(".show-details").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						$(element).trigger('click');
					} 
				});
				});
			}else if(tmp[1]!='' && tmp[1]!=undefined){
				if($('.detail-recruitment').length){
					$('.back').trigger('click');
				}
				$(".sub-nav li a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						$(element).trigger('click');
					}
				});
			}
        }
		
		if($('#projects-page').length){
			$(".sub-nav li a").each(function(index, element) {
				if ($(element).attr('href') == tmp_url) {
					$(element).trigger('click');
				}
			});
		}
		
		if($('#project-details-page').length){
			if(tmp[3]!='' && tmp[3]!=undefined){
				$(".sub-nav li a").each(function(index, element) {
					if($(element).attr('href')==httpserver +tmp[0] + '/' + tmp[1] + '/' + tmp[2] + '.html'){
						$(element).trigger('click');
					}
					
					$(".link-page a").each(function(index, element) {
						if($(element).attr('href')==tmp_url){
							$(element).trigger('click');
						}
						
					});
				});
			}else if(tmp[2]!='' && tmp[2]!=undefined){
				$(".sub-nav li a").each(function(index, element) {
					if($(element).attr('href')==tmp_url){
						$(element).trigger('click');
					}
				});
			}
		}
		
		if($('#news-page').length){
			$(".sub-list li a").each(function(index, element) {
				if ($(element).attr('href') == tmp_url) {
					$(element).trigger('click');
				}
			});
		}
		
		if($('#news-details-page').length){
			$(".link-page a").each(function(index, element) {
				if ($(element).attr('href') == tmp_url) {
					$(element).trigger('click');
				}
			});
		}

        



    }else{
		var tmpurl = document.URL;
		
		if($('#news-details-page').length){
			$(".link-page a").each(function(index, element) {
				if ($(element).attr('href') == tmpurl) {
					$(element).trigger('click');
				}
			});
		}
	}


});


window.onorientationchange = ResizeWindows;


	