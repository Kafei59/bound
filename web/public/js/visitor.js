/* 
* @Author: gicque_p
* @Date:   2015-10-28 13:01:40
* @Last Modified by:   gicque_p
* @Last Modified time: 2015-11-06 17:22:33
*/

$(function() {

    var height = $('.overbox').height();
    var width = $('.overbox').width();
    var position = $('.overbox').offset();

    $('.offbox').css({
        'height': height, 
        'width': width,
        'left': position.left - 20,
        'top': position.top + 20
    });

    $('a').click(function(e) {
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
