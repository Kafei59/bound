/* 
* @Author: gicque_p
* @Date:   2015-10-28 13:01:40
* @Last Modified by:   gicque_p
* @Last Modified time: 2015-11-12 17:52:24
*/

function isVisible(elementToBeChecked) {
    var TopView = $(window).scrollTop();
    var BotView = TopView + $(window).height();
    var TopElement = $(elementToBeChecked).offset().top;
    var BotElement = TopElement + $(elementToBeChecked).height();
    return ((BotElement <= BotView) && (TopElement >= TopView));
}

$(function() {
    $(document).ready(function () {

        var height = 0;
        if ($('.sections')) {
            var height = $('.header').height();
            $('.sections').css('margin-top', height);
        }

        $('nav a, .sections a').click(function() {
            $('html, body').animate({
                scrollTop: $($(this).attr('href')).offset().top - height
            }, 800);

            return false;
        });

        $(window).scroll(function(){
            if (isVisible($('#welcome h1'))) {
                $('a[href=#welcome]').parent().addClass('active');
            } else {
                $('a[href=#welcome]').parent().removeClass('active');
            }

            if (isVisible($('#concept h1'))) {
                $('a[href=#concept]').parent().addClass('active');
            } else {
                $('a[href=#concept]').parent().removeClass('active');
            }
            
            if (isVisible($('#design h1'))) {
                $('a[href=#design]').parent().addClass('active');
            } else {
                $('a[href=#design]').parent().removeClass('active');
            }

            if (isVisible($('#contact h1'))) {
                $('a[href=#contact]').parent().addClass('active');
            } else {
                $('a[href=#contact]').parent().removeClass('active');
            }
        });
    });
});

$(function() {
    $(document).ready(function () {
        var height = $('.overbox').height();
        var width = $('.overbox').width();
        var position = $('.overbox').offset();

        if (position) {    
            $('.offbox').css({
                'height': height, 
                'width': width,
                'left': position.left - 20,
                'top': position.top + 20
            });
        }

        $('.form-box a').click(function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
            setTimeout(function() {
                window.location.href = href;
            }, 600);
        })

        setTimeout(function() {
            $(".input input").each(function() {
                if ($(this).val() != "" || $(this).hasClass('fill')) {
                    $(this).parent(".input").each(function() {
                        $("label", this).css({
                            'line-height': "18px",
                            'font-size': "1em",
                            'font-weight': "100",
                            'top': "0px",
                        })
                        
                        if ($(".login-box").length) {
                            $("label", this).css({
                                'color': "#78909C"
                            })
                        } else {
                            $("label", this).css({
                                'color': "#CFD8DC"
                            })
                        }

                        $(".spin", this).css({
                            'width': "0px"
                        })
                    })
                }
            })
        }, 100);

        $(".input input")
            .focus(function() {
                $(this).parent(".input").each(function() {
                    $("label", this).css({
                        'line-height': "18px",
                        'font-size': "1em",
                        'font-weight': "100",
                        'top': "0px"
                    })

                    if ($(".login-box").length) {
                        $("label", this).css({
                            'color': "#78909C"
                        })
                    } else {
                        $("label", this).css({
                            'color': "#212121"
                        })
                    }
                    
                    $(".spin", this).css({
                        'width': "100%"
                    })
                });
            })

            .blur(function() {
                $(".spin").css({
                    'width': "0px"
                })
        
                if ($(this).val() == "") {
                    $(this).parent(".input").each(function() {
                        $("label", this).css({
                           'line-height': "60px",
                           'font-size': "1.5em",
                           'font-weight': "300",
                           'top': "10px"
                        })

                        if ($(".login-box").length) {
                            $("label", this).css({
                               'color': "#212121"
                            })
                        } else {
                            $("label", this).css({
                                'color': "#FFFFFF"
                            })
                        }

                    });
                }
            });

        $('#remember_me').click(function() {
            if ($(this).is(':checked')) {        
                $('.remember-me').css({
                    'color': "#ED2553"
                })
            } else {
                $('.remember-me').css({
                    'color': "#212121"
                })            
            }
        })

        $(".alt").click(function() {
            if (!$(this).hasClass('animate-button')) {
                $(".shape").css({
                    'width': "100%",
                    'height': "100%",
                    'transform': "rotate(0deg)",
                })

                setTimeout(function() {
                    $(".overbox").css({"overflow": "initial"})
                }, 600)

                $(this).animate({
                    'width': "140px",
                    'height': "140px"
                }, 500);
            }
        })

       $(".animate-button").click(function() {

            if ($(this).hasClass('animate-button')) {
                setTimeout(function() {
                    $(".overbox").css({
                        'overflow': "hidden"
                    })
                }, 200)

                $(this).addClass('active').animate({
                    'width': "1000px",
                    'height': "1000px"
                });

                $(".shape").css({
                    'width': "0",
                    'height': "0",
                    'content': "none"
                })
            }

            if ($(".alt").hasClass('material-buton')) {
                $(".alt").removeClass('material-buton');
                $(".alt").addClass('animate-button');
            }
       });
   });
});
