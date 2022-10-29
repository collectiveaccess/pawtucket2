var $ = jQuery.noConflict();

/****************************************************
********************** LOADER ***********************
****************************************************/
$(window).on('load', function () {

    $( ".loader" ).fadeTo( "slow" , 0, function() {
        // Animation complete.
    });
    setTimeout(function() {
        $('.loader').css('display', 'none');
    }, 700);

});


/****************************************************
***************** SPLASH PAGE MAP *******************
****************************************************/
var intervalId = window.setInterval(function(){

    // remove visible class from a random visible pin
    var len = $(".map_pin.visible").length;
    var random = Math.floor( Math.random() * len );
    //console.log(len + ' - ' + random);
    $(".map_pin.visible").eq(random).removeClass("visible");

    // add visible class to a random hidden pin
    var len = $(".map_pin:not(.visible)").length;
    var random = Math.floor( Math.random() * len );
    //console.log(len + ' - ' + random);
    $(".map_pin:not(.visible)").eq(random).addClass("visible");

}, 1250);



/****************************************************
****************** STICKY HEADER ********************
****************************************************/
$(window).on("load resize",function() {

	var viewportWidth = window.innerWidth

	if (viewportWidth < 1050) {
		$("body").addClass("fixed");
	}

});


$(window).on("scroll",function() {

	var viewportWidth = window.innerWidth

	if (viewportWidth > 1050) {
		 // distance scrolled
         var scrollTop = $(window).scrollTop();

         if (scrollTop > 200) {
             $('body').addClass("fixed");
         }
         else {
             $('body').removeClass("fixed");
         }
	}

});


/****************************************************
********************** SEARCH ***********************
****************************************************/
jQuery ( document ).ready ( function($) {
    $('.open_search').on('click', function (e) {
        $('.search_overlay').addClass('show');
    });
    $('.search_overlay .close').on('click', function (e) {
        $('.search_overlay').removeClass('show');
    });
});


/****************************************************
******************* BURGER MENU *********************
****************************************************/
// Hide / Show menu
jQuery ( document ).ready ( function($) {
	$( ".burger" ).click(function() {
		$("ul.main_menu").toggleClass('show');
		$(".burger").toggleClass('open');
	});
});


/****************************************************
***************** ANCHOR TRANSITIONS ****************
****************************************************/

// commented out cause was messing with the link to open media panel in section_media_html.php

// if a link with an anchor is clicked
//jQuery ( document ).ready ( function($) {
//    $('a[href*=\\#]').on('click', function (e) {
//        if(this.pathname === window.location.pathname){
//            e.preventDefault(); 
//            var dest = $(this).attr('href'); 
//            var menuHeight = $('header').outerHeight(); 
//            $('html,body').animate({ 
//                scrollTop: $(dest).offset().top - menuHeight
//            }, 3500); 
//        }
//    });
//});



/****************************************************
****************** CHANGE FONT SIZE *****************
****************************************************/
// if a link with an anchor is clicked
jQuery ( document ).ready ( function($) {
    $('.font_size .font').on('click', function (e) {
        // remove active state from fonts
        $('.font_size div').removeClass('active');
        // add active class to clicked font
        $(this).addClass('active');
        // remove class from body
        $('body').removeClass('big_text');
        // if clicked font was big then add big_text class to body
        if ( $(this).hasClass('big') ) {
            $('body').addClass('big_text');
        }
    });
});


//////////////////////////////////////////////////////// 
/////////////// Sticky sidebar ////////////
////////////////////////////////////////////////////////
$(window).on("load resize",function() {

	var viewportWidth = window.innerWidth

	if (viewportWidth > 1050 && $(".column.right")[0]) {

		var sidebar = new StickySidebar('.column.right', {
		    containerSelector: '.columns',
		    innerWrapperSelector: '.sidebar__inner',
		    topSpacing: 90,
		    bottomSpacing: 40
		});

	}

});



/****************************************************
******************* HOME SWIPER INIT ****************
****************************************************/
jQuery ( document ).ready ( function($) {
    var options = {
        // Optional parameters
        slidesPerView: "auto",
        centeredSlides: true,
        spaceBetween: 30,
        loop: true,
        initialSlide: 0,

        // Lazy load
        // preloadImages: false, // Disable preloading of all images
        // lazy: true, // Enable lazy loading

        autoplay: {
            delay: 5000,
            disableOnInteraction: true,
        },

        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        
    };
    // Inicio el slider con las opciones
    carousel = new Swiper ('.home_galleries', options); 
});



/****************************************************
**************** EXHIBITION SWIPER INIT *************
****************************************************/

/*
moved to views/Section/section_media_html.php
*/


/****************************************************
**************** GALLERY SWIPER INIT ****************
****************************************************/
jQuery ( document ).ready ( function($) {
var swiper = new Swiper(".gallery_thumbnails", {
    spaceBetween: 10,
    slidesPerView: "auto",
    spaceBetween: 20,
    freeMode: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
  });
  var swiper2 = new Swiper(".gallery_main", {
    spaceBetween: 10,
    preloadImages: false,
    lazy: true,
    lazy: {
        threshold: 50,
        loadPrevNext: true,
        loadPrevNextAmount: 2,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    thumbs: {
      swiper: swiper,
    },
  });
});



/****************************************************
********************* SORTABLE TABLE *******************
****************************************************/
function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("sortable_table");
    switching = true;
    // Set the sorting direction to ascending:
    dir = "asc";
    /* Make a loop that will continue until
    no switching has been done: */
    while (switching) {
        // Start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /* Loop through all table rows (except the
        first, which contains table headers): */
        for (i = 1; i < (rows.length - 1); i++) {
        // Start by saying there should be no switching:
        shouldSwitch = false;
        /* Get the two elements you want to compare,
        one from current row and one from the next: */
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];
        /* Check if the two rows should switch place,
        based on the direction, asc or desc: */
        if (dir == "asc") {
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            // If so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
            }
        } else if (dir == "desc") {
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            // If so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
            }
        }
        }
        if (shouldSwitch) {
        /* If a switch has been marked, make the switch
        and mark that a switch has been done: */
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        // Each time a switch is done, increase this count by 1:
        switchcount ++;
        } else {
        /* If no switching has been done AND the direction is "asc",
        set the direction to "desc" and run the while loop again. */
        if (switchcount == 0 && dir == "asc") {
            dir = "desc";
            switching = true;
        }
        }
    }
}

/****************************************************
****************** BACK TO TOP BUTTON ********************
****************************************************/
$(window).scroll(function() {

	// distance scrolled
	var scrollTop = $(window).scrollTop();

    if (scrollTop > 200) {
    	$('.back_to_top').addClass("show");
    }
    else {
    	$('.back_to_top').removeClass("show");
    }

});
