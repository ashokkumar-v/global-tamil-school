
    function banner_slider() {
        var owl = $(".banner_slider");
        owl.owlCarousel({
            loop: true,
            margin: 0,
            responsiveClass: true,
            items: 1,
            smartSpeed: 1000,
			navigation: true,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            nav: false,
            dots: false,
			arrows: false,
            autoplay: true,
            autoplayTimeout: 4000,
            center: true,
            responsive: {
                0: {
                    items: 1,
					loop: true
                },
                480: {
                    items: 1,
					loop: true
					
                },
                760: {
                    items: 1,
					loop: true
					
                }
            }
        });
    }
    banner_slider();
	
	
	function about_slider() {
        var owl = $(".about_slider");
        owl.owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            navigation: true,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            nav: true,
            items: 4,
            smartSpeed: 1000,
            dots: false,
            autoplay: true,
            autoplayTimeout: 4000,
			responsive: {
                0: {
                    items: 2
                },
                480: {
                    items: 2,
					
					
                },
                760: {
                    items: 3,
					
					
                },
				
				1024: {
                    items: 4,
					
                },
				
            }
                        
        });
    }
    about_slider();


function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

         return true;
       }
	   
