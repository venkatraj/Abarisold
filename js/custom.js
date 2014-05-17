jQuery(document).ready(function($){

  $('#masthead').waypoint('sticky');

  $('.flexslider').flexslider({
    animation: "slide",
    controlNav: false
  });

  $('.flex-recent-posts').flexslider({
    animation: "slide",
    animationLoop: false,
    controlNav: false,
    itemWidth: 292,
    slideshow: false
    //itemMargin: 30
  });

  $('.main-navigation').slicknav({
    duration: 700
  });

  $(window).scroll(function() {

    $('.services h3').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeIn");
        $(this).addClass("animated");
      }
    });

    $('#service1 div').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeftBig");
        $(this).addClass("animated");
      }
    });


    $('#service2 div').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInUpBig");
        $(this).addClass("animated");
      }
    });

    $('#service3 div').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInRightBig");
        $(this).addClass("animated");
      }
    });   

    $('.feature2 li:nth-child(1)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft");
        $(this).addClass("animated");
      }
    });

    $('.feature2 li:nth-child(2)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft2");
        $(this).addClass("animated");
      }
    }); 

    $('.feature2 li:nth-child(3)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft3");
        $(this).addClass("animated");
      }
    });  

    $('.feature2 li:nth-child(4)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft4");
        $(this).addClass("animated");
      }
    }); 

    $('.feature2 li:nth-child(5)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft5");
        $(this).addClass("animated");
      }
    });

    $('.feature2 li:nth-child(6)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft6");
        $(this).addClass("animated");
      }
    });

    $('.feature2 li:nth-child(7)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft7");
        $(this).addClass("animated");
      }
    }); 

    $('.feature2 li:nth-child(8)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft8");
        $(this).addClass("animated");
      }
    });

    $('.feature2 li:nth-child(9)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft9");
        $(this).addClass("animated");
      }
    });

    $('.feature2 li:nth-child(10)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft10");
        $(this).addClass("animated");
      }
    });

    $('#skills .skill-container:nth-of-type(1)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("slideInLeft");
        $(this).addClass("animated");
      }
    }); 

    $('#skills .skill-container:nth-of-type(2)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("slideInRight");
        $(this).addClass("animated");
      }
    });

    $('#skills .skill-container:nth-of-type(3)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("slideInLeft");
        $(this).addClass("animated");
      }
    });   

    $('#skills .skill-container:nth-of-type(4)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("slideInRight");
        $(this).addClass("animated");
      }
    });

    $('#skills .skill-container:nth-of-type(5)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("slideInLeft");
        $(this).addClass("animated");
      }
    });

    $('.flex-recent-posts .slides li:nth-of-type(1)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+350) {
        $(this).addClass("fadeIn");
        $(this).addClass("animated");
      }
    });

    $('.flex-recent-posts .slides li:nth-of-type(2)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+350) {
        $(this).addClass("fadeIn2");
        $(this).addClass("animated");
      }
    }); 

    $('.flex-recent-posts .slides li:nth-of-type(3)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+350) {
        $(this).addClass("fadeIn3");
        $(this).addClass("animated");
      }
    });

    $('.flex-recent-posts .slides li:nth-of-type(4)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+350) {
        $(this).addClass("fadeIn4");
        $(this).addClass("animated");
      }
    });    

  });

     /* Get the window's width, and check whether it is narrower than 480 pixels */
   var windowWidth = $(window).width();

   if (windowWidth <= 600) {

      /* Clone our navigation */
      var mainNavigation = $('div.menu-main-nav-container').clone();

      /* Replace unordered list with a "select" element to be populated with options, and create a variable to select our new empty option menu */
      $('div.menu-main-nav-container').html('<select class="menu"></select>');
      var selectMenu = $('select.menu');

      /* Navigate our nav clone for information needed to populate options */
      $(mainNavigation).children('ul').children('li').each(function() {

         /* Get top-level link and text */
         var href = $(this).children('a').attr('href');
         var text = $(this).children('a').text();

         /* Append this option to our "select" */
         $(selectMenu).append('<option value="'+href+'">'+text+'</option>');

         /* Check for "children" and navigate for more options if they exist */
         if ($(this).children('ul').length > 0) {
            $(this).children('ul').children('li').each(function() {

               /* Get child-level link and text */
               var href2 = $(this).children('a').attr('href');
               var text2 = $(this).children('a').text();

               /* Append this option to our "select" */
               $(selectMenu).append('<option value="'+href2+'">--- '+text2+'</option>');
            });
         }
      });
   }

   /* When our select menu is changed, change the window location to match the value of the selected option. */
   $(selectMenu).change(function() {
      location = this.options[this.selectedIndex].value;
   });

});

