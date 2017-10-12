/* global thecipherbriefScreenReaderText */
function startDrag(e) {
    var textarea = $(this).prev().children('textarea');
    staticOffset = textarea.height() - e.pageY;
    textarea.css('opacity', 0.25);
    $(document).mousemove(performDrag).mouseup(endDrag);
    return false;
}

function performDrag(e) {
    var textarea = $('.grippie').prev().children('textarea');
    textarea.height(Math.max(32, staticOffset + e.pageY) + 'px');
    return false;
}

function endDrag(e,textarea) {
    var textarea = $('.grippie').prev().children('textarea');
    $(document).unbind('mousemove', performDrag).unbind('mouseup', endDrag);
    $(textarea).css('opacity', 1);
}
(function( $ ) {
    $('#edit-reset').on('click',function(e){
        e.preventDefault();
        $('#edit-search-api-views-fulltext').val('');
        $('#views-exposed-form-search-page').submit();
    });

    $('.popup-video').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });

    $('.grippie').mousedown(startDrag);

    var $container = $('.boxcontainer');

    $(window).on("load",function(){
        $('#mCSB_1').mCustomScrollbar();
        $('#mCSB_2').mCustomScrollbar();
    });

    $(".menu-toggle").on('click',function(e) {
        e.preventDefault();
        $(".menu_hide_responsive").slideToggle();

    });

    $(".baner_close").on('click',function(){
        $(".header_baner").hide();
        $('body').css('padding-top', '140px');
    });

    $(".regular").slick({
        dots: true,
        infinite: true,
        slidesToShow: 2,
        slidesToScroll: 2,
        responsive:
        [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
        ]
      });
    //
    $('.paginationAjax .next').on('click',function () {
        loadContents($(this),$container);
        return false;
    });
})( jQuery );

function loadpopupSocial(em,$what){
    var shareurl=em.href;
    var top = (screen.availHeight - 500) / 2;
    var left = (screen.availWidth - 500) / 2;
    if($what && $what == 'twitter'){
        var main = {
            text : '',
            url   : '',
            via   : 'thecipherbrief',
            related   : 'twitterapi twitter',
        };
        $('meta').each(function(){
            $key = $(this).attr("name") ? $(this).attr("name") : $(this).attr("property");
            if($key == 'og:title'){
                main.text = $(this).attr("content");
            }
            if($key == 'og:url'){
                main.url += $(this).attr("content");
            }
        });
        var popup = window.open(
            shareurl+'?'+jQuery.param( main ),
            'social sharing',
            'width=550,height=420,left='+ left +',top='+ top +',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1'
        );
        return false;
    }
    if($what && $what == 'linkedin'){
        var main = {
            mini : true,
            title : '',
            url   : '',
            source   : '',
        };

        $('meta').each(function(){
            $key = $(this).attr("name") ? $(this).attr("name") : $(this).attr("property");
            if($key == 'og:title'){
                main.title = $(this).attr("content");
            }
            if($key == 'og:url'){
                main.url    = $(this).attr("content");
                main.source = $(this).attr("content");
            }
            if($key == 'og:description'){
                main.source = $(this).attr("content");
            }
        });
        var popup = window.open(
            shareurl+'?'+jQuery.param( main ),
            'social sharing',
            'width=550,height=420,left='+ left +',top='+ top +',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1'
        );
        return false;
    }
    if(!$what){
        var popup = window.open(
            shareurl,
            'social sharing',
            'width=550,height=420,left='+ left +',top='+ top +',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1'
        );
        return false;
    }
}
function loadContents($this,$container) {
    $this.addClass('load');
    $(".loader").show();
    var url = $this.attr('href');
    if (url) {
        $.ajax({
            type: "GET",
            url: url,
            dataType: "html",
            timeout: 6000,
            error: function () {
                loadContents();
            },
            success: function (loaded) {
                var result   = $(loaded).find('.boxcontainer .views-row');
                var nextlink = $(loaded).find('.paginationAjax .next').attr('href');
                $this.removeClass('load');
                $(".loader").hide();
                console.log($container);
                console.log(result);
                $container.append(result);
                if (nextlink != undefined) {
                    $('.paginationAjax .next').attr('href', nextlink);
                } else {
                    $('.paginationAjax').remove();
                }
                loading = false;
            }
        });
    }
}
