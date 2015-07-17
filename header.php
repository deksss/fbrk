<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	global $page, $paged;
	wp_title( '|', true, 'center' );
	bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) echo " | $site_description";
	if ( $paged >= 2 || $page >= 2 ) echo ' | ' . sprintf( __( 'Page %s', 'imbalance2' ), max( $paged, $page ) );
?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
	wp_head();
?>
<link href='libs/Rod.ttf' rel='stylesheet' type='text/css'>
<style type="text/css">
/* color from theme options */
<?php $color = getColor() ?>
body, input, textarea { font-family: <?php echo getFonts() ?>; }
a, .menu a:hover, #nav-above a:hover, #footer a:hover, .entry-meta a:hover { color: <?php echo $color ?>; }
.fetch:hover { background: <?php echo $color ?>; }
blockquote { border-color: <?php echo $color ?>; }
.menu ul .current-menu-item a { color: <?php echo $color ?>; }
#respond .form-submit input { background: <?php echo $color ?>; }

<?php if ( (has_tag('16')) && !( is_home() || is_front_page() ) ): ?>
  html {background-color:black;}	
  #content {background-color:black;}
<?php else: ?>
 html {background-color:transparent;}	
 #content {background-color:color:white;}
<?php endif ?>


<?php if (  (has_tag('no-title')) && !( is_home() || is_front_page() ) ): ?>
	.post_title {display:none;}
  .entry-title {display:none;}
<?php else: ?>
	.post_title {display:block;}
 .entry-title {display:block;}
<?php endif ?>

<?php if (!fluidGrid()): ?>
.wrapper {  margin: 0 auto; padding-left: 20px; padding-right: 20px;  }
<?php else: ?>
.wrapper { margin: 0 auto; }
<?php endif ?>

.box .texts { border: 20px solid <?php echo $color ?>; background: <?php echo $color ?>;  }
<?php if (!imagesOnly()): ?>
.box .categories { padding-top: 15px; }
<?php endif ?>
</style>

<script type="text/javascript">
$(document).ready(function() {
	// shortcodes
	$('.wide').detach().appendTo('#wides');
	$('.aside').detach().appendTo('.entry-aside');

	// fluid grid
	<?php if (!fluidGrid()): ?>
	function wrapperWidth() {
		var wrapper_width = $('body').width() - 20;
		wrapper_width = Math.floor(wrapper_width / 250) * 250 - 40;
		//if (wrapper_width < 1890) wrapper_width = 1890;
		$('.wrapper').css('width', wrapper_width);
	}
	wrapperWidth();
	$(window).resize(function() {
		wrapperWidth();
	});
	<?php endif ?>

	// search
	$(document).ready(function() {
		$('#s').val('Search');
	});

	$('#s').bind('focus', function() {
		$(this).css('border-color', '<?php echo $color ?>');
		if ($(this).val() == 'Search') $(this).val('');
	});

	$('#s').bind('blur', function() {
		$(this).css('border-color', '#DEDFE0');
		if ($(this).val() == '') $(this).val('Search');
	});

	// grid
	$('#boxes').masonry({
		itemSelector: '.box',
		columnWidth: 210,
		gutterWidth: 40
	});

	$('#related').masonry({
		itemSelector: '.box',
		columnWidth: 210,
		gutterWidth: 40
	});
	
	$('.texts').on({
		'mouseenter': function() {
			if ($(this).height() < $(this).find('.abs').height()) {
				$(this).height($(this).find('.abs').height());
			}
			$(this).stop(true, true).animate({
				'opacity': '1',
				'filter': 'alpha(opacity=100)'
			}, 0);
		},
		'mouseleave': function() {
			$(this).stop(true, true).animate({
				'opacity': '0',
				'filter': 'alpha(opacity=0)'
			}, 0);
		}
	});
	
	
	$('a[rel=external]').attr('target','_blank');
	
	// картинка из превью в хедер
	$('.wp-post-image').hover(function(){
		var src = "url(" + $(this).attr('src') + ")";
		var src = src.replace(/[-]\d+[x]\d+/,'');  
   		$('body, #header').css("background-image", src );
		$('body, #header').css("background-position", "50% 0");
		$('body, #header').addClass("dark-bg");
    		}, function(){
    		$('body, #header').css("background-image", "url('wp-content/themes/fabrika2/fabrika2/images/fon-sprite.png')");
		$('body, #header').css("background-position", "0 -5460px");
	$('body, #header').removeClass("dark-bg"); 
	});


	// menu button
	$('#menu-button-wrap').bind('click', function() {
		$(this).find('.hamburger--line').toggleClass('hamburger--line__x');
	if ( $(this).find('.hamburger--line').hasClass('hamburger--line__x')) {
		$('#wrapper-menu-right').css("display", "block");
		$('#menu-right').css("visibility", "visible").animate({top: "+=500px"}, 400 );	
 	} else {
		$('#menu-right').css("visibility", "hidden").animate({top: "-=500px"}, 300 );
		$('#wrapper-menu-right').css("display", "none"); 
	}
	});

	

	// comments
	$('.comment-form-author label').hide();
	$('.comment-form-author span').hide();
	$('.comment-form-email label').hide();
	$('.comment-form-email span').hide();
	$('.comment-form-url label').hide();
	$('.comment-form-comment label').hide();

	if ($('.comment-form-author input').val() == '')
	{
		$('.comment-form-author input').val('Name (required)');
	}
	if ($('.comment-form-email input').val() == '')
	{
		$('.comment-form-email input').val('Email (required)');
	}
	if ($('.comment-form-url input').val() == '')
	{
		$('.comment-form-url input').val('URL');
	}
	if ($('.comment-form-comment textarea').html() == '')
	{
		$('.comment-form-comment textarea').html('Your message');
	}
	
	$('.comment-form-author input').bind('focus', function() {
		$(this).css('border-color', '<?php echo $color ?>').css('color', '#333');
		if ($(this).val() == 'Name (required)') $(this).val('');
	});
	$('.comment-form-author input').bind('blur', function() {
		$(this).css('border-color', '<?php echo '#ccc' ?>').css('color', '#6b6b6b');
		if ($(this).val().trim() == '') $(this).val('Name (required)');
	});
	$('.comment-form-email input').bind('focus', function() {
		$(this).css('border-color', '<?php echo $color ?>').css('color', '#333');
		if ($(this).val() == 'Email (required)') $(this).val('');
	});
	$('.comment-form-email input').bind('blur', function() {
		$(this).css('border-color', '<?php echo '#ccc' ?>').css('color', '#6b6b6b');
		if ($(this).val().trim() == '') $(this).val('Email (required)');
	});
	$('.comment-form-url input').bind('focus', function() {
		$(this).css('border-color', '<?php echo $color ?>').css('color', '#333');
		if ($(this).val() == 'URL') $(this).val('');
	});
	$('.comment-form-url input').bind('blur', function() {
		$(this).css('border-color', '<?php echo '#ccc' ?>').css('color', '#6b6b6b');
		if ($(this).val().trim() == '') $(this).val('URL');
	});
	$('.comment-form-comment textarea').bind('focus', function() {
		$(this).css('border-color', '<?php echo $color ?>').css('color', '#333');
		if ($(this).val() == 'Your message') $(this).val('');
	});
	$('.comment-form-comment textarea').bind('blur', function() {
		$(this).css('border-color', '<?php echo '#ccc' ?>').css('color', '#6b6b6b');
		if ($(this).val().trim() == '') $(this).val('Your message');
	});
	$('#commentform').bind('submit', function(e) {
		if ($('.comment-form-author input').val() == 'Name (required)')
		{
			$('.comment-form-author input').val('');
		}
		if ($('.comment-form-email input').val() == 'Email (required)')
		{
			$('.comment-form-email input').val('');
		}
		if ($('.comment-form-url input').val() == 'URL')
		{
			$('.comment-form-url input').val('');
		}
		if ($('.comment-form-comment textarea').val() == 'Your message')
		{
			$('.comment-form-comment textarea').val('');
		}
	})

	$('.commentlist li div').bind('mouseover', function() {
		var reply = $(this).find('.reply')[0];
		$(reply).find('.comment-reply-link').show();
	});

	$('.commentlist li div').bind('mouseout', function() {
		var reply = $(this).find('.reply')[0];
		$(reply).find('.comment-reply-link').hide();
	});
});
</script>

<?php echo getFavicon() ?>
</head>

<body <?php body_class(); ?>>
		

<?php if ( is_single() ): ?>
	<div class="social-button">
        <div id="social-vk"> <a href="http://vk.com/deti_zavoda" target="blank"> </a></div>
        <div id="social-fb"><a href="https://www.facebook.com/pages/%D0%A4%D0%B0%D0%B1%D1%80%D0%B8%D0%BA%D0%B0/1579542702333805" target="blank"> </a></div>
        <div id="social-tw"><a href="https://twitter.com/deti_zavoda" target="blank"> </a></div>
	</div>
	
<div class="nav-button">
        <div id="nav-button-up"> </div>
	<div id="nav-button-lft"> </div>
</div>


<script type="text/javascript">

$(document).ready(function () {
//insert true adress
var curUrl = window.location.href,
    strLength = curUrl.length,
    lastL,
    imgSrc,
    fileSuf = '-fon.jpg', 
    uploadDir = 'http://localhost:81/wordpress/wp-content/uploads/';
curUrl = curUrl.substring(0, strLength - 1);
lastL = curUrl.lastIndexOf('/');
imgSrc = uploadDir  + curUrl.substring(lastL, strLength) + fileSuf;
$('body').css("background-image", "url('"+imgSrc +"')");
$('body').css("background-position", "50% 0");
});

$(document).ready(function () {
                $(".wrapper").css('margin-top', 380);
		$(".social-button").css("display", "block");
		$(".social-button").css('right', $(".wrapper").css("margin-right"));
           	$(".social-button").css('top', '340px');
		$("#nav-button-lft").show();
		$("#nav-button-lft").css('top', '415px');
		$("#nav-button-lft").css('left', $(".wrapper").css("margin-left"));
		$("#nav-button-up").css('top', '15px');
		$("#nav-button-up").css('right','15px');
		$("#nav-button-up").css('left', 'inherit');
		$("#nav-button-up").css('margin', 'inherit');
		});

$(window).scroll(function() {
		if ($(this).scrollTop() > 100) {
		$("#nav-button-up").show();
		$(".social-button").addClass( "social-button-vertical" );			
} 
else {
		$("#nav-button-up").hide();
		$(".social-button").removeClass( "social-button-vertical" );		
}
		if ($(this).scrollTop() > 400) {
		$("#nav-button-up").show();			
} 
});

$("#nav-button-up").click(function () {
 window.scrollTo(0, 0);
    });
//insert true adress
$("#nav-button-lft").click(function () {
 window.location.href = 'http://localhost:81/wordpress/';
    });

</script>
<?php endif ?>

<?php if ( $site_description && ( is_home() || is_front_page() ) ): ?>
<div id="header">
        <div class="header-top-menu">
        	<div class="header-top-menu-item" href="header-boxes-team">КОМАНДА</div>
        	<div class="header-top-menu-item" href="header-boxes-mission">МИССИЯ</div>
        	<div class="header-top-menu-item" href="header-boxes-hr">РЕКРУТИНГ</div>
	</div>
            <div id="logo-top">
                <img id="logo-img"></img>
            </div>
        <div id="header-boxes">
            <div class="header-box" id="header-boxes-team">1</div>
            <div class="header-box" id="header-boxes-mission">2</div>
            <div class="header-box" id="header-boxes-hr">3</div>
        </div>   


</div>
	
<div class="social-button">
        <div id="social-vk"> <a href="http://vk.com/deti_zavoda" target="blank"> </a></div>
        <div id="social-fb"><a href="https://www.facebook.com/pages/%D0%A4%D0%B0%D0%B1%D1%80%D0%B8%D0%BA%D0%B0/1579542702333805" target="blank"> </a></div>
        <div id="social-tw"><a href="https://twitter.com/deti_zavoda" target="blank"> </a></div>
</div>

<div class="nav-button">
        <div id="nav-button-up"> </div>
        <div id="nav-button-dwn"> </div>
	<div id="nav-button-lft"> </div>
</div>

<script type="text/javascript">
var fonElement = $("body"),
    logoTop = $("#logo-top"),
    flagLandingModeFinish = false,
    docHeight = window.innerHeight,
    logoPosTop = Math.round(
    (docHeight / 2) - (logoTop.height() / 2)),
    header = $("#header"),
    headerHeight = docHeight,
    headerHeightFinish = 400,
    headerMarginTop = headerHeight - headerHeightFinish,
    headScrnPos,
    steapH = headerHeight / 100,
    stepCount,
    main = $(".wrapper");

function initHeader() {
    flagLandingModeFinish = false;
    logoTop.css("top", logoPosTop);
    logoTop.css("display", 'block');
    header.css('height', headerHeight);
    header.css('background-img', 'none');
    header.removeClass('header-fixed');
    $("#header-boxes").css("display", "block");
    $(".header-top-menu").css("display", "block");
    $(".wrapper").css('margin-top', 20);
    $(".social-button").css("display", "none");
    $("#nav-button-up").hide();
    $("#nav-button-dwn").show();
    window.scrollTo(0, 0);
    fonElement.css(
                "background-position", '0px 0px');
}

logoTop.css("top", logoPosTop);
logoTop.css("display", 'block');
header.css('height', headerHeight);

$("#nav-button-dwn").click(function () {
    $(window).scrollTop(headerHeight);
    $("#nav-button-dwn").hide();
});



$(window).scroll(function () {
    if (flagLandingModeFinish === false) {

        if ($(this).scrollTop() > 51) {
            fonElement.css(
                "background-position", '0px 0px');

        }
        if ($(this).scrollTop() > 99) {
            fonElement.css(
                "background-position", '0px -1365px');

        }
        if ($(this).scrollTop() > 199) {
            fonElement.css(
                "background-position", '0px -2730px');

        }
        if ($(this).scrollTop() > 299) {
            fonElement.css(
                "background-position", '0px -4095px');

        }
        if ($(this).scrollTop() > 399) {
            fonElement.css(
                "background-position", '0px -5460px');
        }
    }
    if ($(this).scrollTop() > headerHeight - 400) {
        flagLandingModeFinish = true;
        //$("#logo-slogan").css("display", "none");
        $("#logo-top").animate({
            top: 140
        }, "slow");

        header.css('left', '0px');
        header.css('top', '0px');
        header.css('height', headerHeightFinish);
        header.css('postion', "fixed");
        header.addClass('header-fixed');
        header.css('width', window.innerWidth);
        $("#header-boxes").css("display", "none");
        $(".header-top-menu").css("display", "none");
        $(".wrapper").css('margin-top', 380);
        $(".social-button").css("display", "block");
        $(".social-button").css('right', $(".wrapper").css("margin-right"));
        $(".social-button").css('top', '340px');
        $("#nav-button-up").show();
        $("#nav-button-dwn").hide();
        window.scrollTo(0, 0);
    }
});


$(document).ready(function () {
   var i = 1,
        imgsForLogo = [],
        numimg = 0,
        imgCount = 21,
        imgElement = $("#logo-img"),
        animSpd = 70;

    for (i; i <= imgCount; i++) {
        imgsForLogo[i] =  "wp-content/themes/fabrika2/fabrika2/images/logo/frame" + i + ".png";
    }
    //чередование изображений 
    function animateTopLogo() {
        imgElement.attr("src", imgsForLogo[numimg]);
        if ( Math.random() > 0.2 ) {
        numimg++; } 
        else{
        numimg = numimg - 1;	
        }
        if (numimg === imgCount || numimg < 0 ) {
            numimg = 0;
        }
        setTimeout(function () {
            animateTopLogo();
        }, animSpd);
    }

    animateTopLogo();});

$(document).ready(function () {
    var ref = "",
	curBox;
//insert true adress
    ref = document.referrer;
    //insert true adress
    if(ref.indexOf('http://localhost:81/wordpress/') + 1) {
        $(window).scrollTop(headerHeight);
        $("#nav-button-dwn").hide();
    }

 
    $(".header-top-menu-item").click(function () {
        $(".header-top-menu-item").css("color", "white");
        $(".header-top-menu-item").css('background', 'transparent');
        $(this).css("color", "black");
        $(this).css("background-color", "white");
        $(".header-box").css("display", "none");
        curBox = $('#' + $(this).attr("href"));
        curBox.delay(250).fadeIn();
    });
});

$("#nav-button-up").click(function () {
    initHeader();
}); 
</script>
<?php endif ?>
  
<div class="wrapper">
	
	<div id="main"> 

	