<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<?php include "css.php";?>
</head>
<body>
<?php include "header.php";?>
<div class="slider-portion wisinsli">
  <div class="slider1">
    <div class="slide animation-edu-3 fadeInDown"> <img src="img/contact-banner.jpg" alt="banner">
    </div>
  </div>
</div>

<div class="clearfix"></div>
<!-- <div class="container">
  <div class="contact-form">
    <div class="heading ani">
      <h1>FEEDBACK <span>FORM</span></h1>
    </div>
    <div class="contact-enq">
      <form enctype="multipart/form-data"  name="contact-enquiry" method="post" action="send-email.php">
          
        <div class="form-group col-lg-4 col-xs-12">
          <input type="text" class="form-control" placeholder="Name" name="name" required>
        </div>
        
        <div class="form-group col-lg-4 col-xs-12">
          <input type="text" class="form-control" placeholder="Mobile No" name="phone" onkeypress="return isNumberKey(event)" maxlength="10" required>
        </div>
                              
        <div class="form-group col-lg-4 col-xs-12">
          <input type="email" class="form-control" placeholder="Email Id" name="email" required>
        </div>
        
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <textarea class="form-control txt_area" name="comment" placeholder="Enter Your Message" required></textarea>
        </div>
                              
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <input type="submit" class="form-control submit" name="submit" value="submit">
        </div>
      </form>	
    </div>
  </div>
</div> -->
<div class="clearfix"></div>
<div class="container">
  <div class="contact-information">
    <div class="col-md-4 col-sm-4 br-addr ani">
      <div class="conta-addr">
        <i class="fa fa-map-marker map_icon" aria-hidden="true"></i>
        <p>77 Echo Court<br>
        Northolt Road<br>
        Harrow, London HA2 0FU</p>
      </div>
    </div>
    <div class="col-md-4 col-sm-4 br-addr ani">
      <div class="conta-addr">
        <i class="fa fa-mobile mob_icon" aria-hidden="true"></i>
        <p>UK Mobile No: +44 74597 13276</p>
        <p>Malaysia Mobile No: +60 11 3539 3014</p>
      </div>
    </div>
    <div class="col-md-4 col-sm-4 ani">
      <div class="conta-addr">
        <i class="fa fa-envelope mail_icon" aria-hidden="true"></i><br>
        <a href="mailto:globaltamilschool@gmail.com">globaltamilschool@gmail.com</a>
      </div>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
<div class="embed-container  maps bg-map" id="map">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d19840.93178204905!2d-0.3904299019036498!3d51.566098289158056!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4876131831e9db65%3A0xfee6d0d07d91d778!2sSouth%20Harrow%2C%20Harrow%20HA2%200FU%2C%20UK!5e0!3m2!1sen!2sin!4v1717904586692!5m2!1sen!2sin" width="100%" class="map-heth" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>

<div class="clearfix"></div>

<?php include "footer.php";?>

<?php include "js.php";?>
<script src="js/set-iframe-height-parent.js"></script>
<script>
(function($){
	$(document).ready(function(){
		$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
			event.preventDefault(); 
			event.stopPropagation(); 
			$(this).parent().siblings().removeClass('open');
			$(this).parent().toggleClass('open');
		});
	});
})(jQuery);
//mobile-menu


function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }

</script>

<script>
$(document).ready(function(){
  $('.slider1').bxSlider({
	 mode: 'fade',auto:true,pager:false,
	  randomStart : true,
        autoHover: true
  });

});
</script>
<script>
$(document).ready(function() {
$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,navigation : true,
    responsiveClass:true,
	 navigation : true,
    slideSpeed : 300,
	pagination: false,
    paginationSpeed : 400,
    autoPlay: true,
	stopOnHover: true,
    responsive:{
        0:{
            items:1,
            nav:true, loop:true,
        },
	   460:{
            items:2,
            nav:true, loop:true
        },
        720:{
            items:3, nav:true,
            loop:true
        },
        1000:{
            items:4,
            nav:true,
            loop:true
        }
		
    }	
	
});
 $( "#owl-demo .owl-prev").php('<img src="img/prev-services.png">');
 $( "#owl-demo .owl-next").php('<img src="img/next-services.png">');
});
    function toggleIcon(e) {
    $(e.target)
        .prev('.panel-heading')
        .find(".more-less")
        .toggleClass('glyphicon-minus  glyphicon-plus ');
}
$('.panel-group').on('hidden.bs.collapse', toggleIcon);
$('.panel-group').on('shown.bs.collapse', toggleIcon);


</script>

<script type="text/javascript">
$(function(){
  $('#portfolio').magnificPopup({
    delegate: 'a',
    type: 'image',
    image: {
      cursor: null,
      titleSrc: 'title'
    },
    gallery: {
      enabled: true,
      preload: [0,1], // Will preload 0 - before current, and 1 after the current image
      navigateByImgClick: true
		}
  });
});
</script>
<script src="js/TweenMax.min.js"></script>
<script src="js/ScrollToPlugin.min.js"></script>
<script>
$(document).ready(function() {
    $('.maps').click(function () {
        $('.maps iframe').css("pointer-events", "auto");
    });
    
    $( ".maps" ).mouseleave(function() {
      $('.maps iframe').css("pointer-events", "none"); 
    });
 });   
 var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 11,
    center: {lat: 41.876, lng: -87.624},
    backgroundColor: 'none'
  });     
</script>
</body>
</html>