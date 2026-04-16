(function($) {

  "use strict";

  var initPreloader = function() {
    $(document).ready(function($) {
    var Body = $('body');
        Body.addClass('preloader-site');
    });
    $(window).load(function() {
        $('.preloader-wrapper').fadeOut();
        $('body').removeClass('preloader-site');
    });
  }

  // init Chocolat light box
	var initChocolat = function() {
		Chocolat(document.querySelectorAll('.image-link'), {
		  imageSize: 'contain',
		  loop: true,
		})
	}

  var initSwiper = function() {

    var swiper = new Swiper(".main-swiper", {
      speed: 500,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });

    var category_swiper = new Swiper(".category-carousel", {
      slidesPerView: 6,
      spaceBetween: 30,
      speed: 500,
      navigation: {
        nextEl: ".category-carousel-next",
        prevEl: ".category-carousel-prev",
      },
      breakpoints: {
        0: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 3,
        },
        991: {
          slidesPerView: 4,
        },
        1500: {
          slidesPerView: 6,
        },
      }
    });

    var brand_swiper = new Swiper(".brand-carousel", {
      slidesPerView: 4,
      spaceBetween: 30,
      speed: 500,
      navigation: {
        nextEl: ".brand-carousel-next",
        prevEl: ".brand-carousel-prev",
      },
      breakpoints: {
        0: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 2,
        },
        991: {
          slidesPerView: 3,
        },
        1500: {
          slidesPerView: 4,
        },
      }
    });

    var products_swiper = new Swiper(".products-carousel", {
      slidesPerView: 5,
      spaceBetween: 30,
      speed: 500,
      navigation: {
        nextEl: ".products-carousel-next",
        prevEl: ".products-carousel-prev",
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 3,
        },
        991: {
          slidesPerView: 4,
        },
        1500: {
          slidesPerView: 6,
        },
      }
    });
  }

  var initProductQty = function() {
    $('.product-qty').each(function() {
        var $el_product = $(this);
        var quantity = parseInt($el_product.find('#quantity-display').text()); // Set initial quantity from display
        var $quantityDisplay = $el_product.find('#quantity-display'); // Select quantity display element
        var maxStock = parseInt($el_product.find('.quantity-right-plus').data('max-stock')); // Ambil jumlah stok maksimum dari tombol

        // Update quantity display function
        var updateDisplay = function() {
            $quantityDisplay.text(quantity);
        };

        // Plus button click event
        $el_product.on('click', '.quantity-right-plus', function(e) {
            e.preventDefault();
            // Cek apakah tombol dalam keadaan disabled
            if (!$(this).prop('disabled') && quantity < maxStock) {
                quantity++; // Increase quantity
                updateDisplay(); // Update display
            }
        });

        // Minus button click event
        $el_product.on('click', '.quantity-left-minus', function(e) {
            e.preventDefault();
            if (!$(this).prop('disabled') && quantity > 1) { // Ensure quantity does not go below 1
                quantity--; // Decrease quantity
                updateDisplay(); // Update display
            }
        });

        // Initialize display
        updateDisplay(); // Set initial display
    });
};


// Panggil fungsi ketika DOM siap
$(document).ready(function() {
    initProductQty();
});


  // init jarallax parallax
  var initJarallax = function() {
    jarallax(document.querySelectorAll(".jarallax"));

    jarallax(document.querySelectorAll(".jarallax-keep-img"), {
      keepImg: true,
    });
  }

  // document ready
  $(document).ready(function() {

    initPreloader();
    initSwiper();
    initProductQty();
    initJarallax();
    initChocolat();

  }); // End of a document

})(jQuery);

const swiper = new Swiper('.category-carousel', {
    navigation: {
        nextEl: '.category-carousel-next',
        prevEl: '.category-carousel-prev',
    },
    slidesPerView: 6, // Menampilkan 6 kategori
    spaceBetween: 10, // Jarak antar kategori
    breakpoints: {
        640: { slidesPerView: 2 },
        768: { slidesPerView: 3 },
        1024: { slidesPerView: 4 },
        1280: { slidesPerView: 6 }, // Menampilkan 6 kategori di layar lebih besar
    },
});


