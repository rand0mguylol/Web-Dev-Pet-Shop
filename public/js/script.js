const filterSection= document.querySelector('.search-section');
const filterSectionMargin = parseFloat(window.getComputedStyle(filterSection).getPropertyValue("margin-top"))
const filterPrevious = filterSection.previousElementSibling;
// const filterPreviousGap = filterPrevious.offsetTop + filterPrevious.offsetHeight + 5;
// const filterSectionHeight = filterPreviousGap + filterSectionMargin;

// console.log(filterSectionHeight)

function addFilterBG( el) { 
  const filterPreviousGap = filterPrevious.offsetTop + filterPrevious.offsetHeight + 5;
  const filterSectionHeight = filterPreviousGap + filterSectionMargin;
  if (window.scrollY >= filterSectionHeight) {
          el.classList.add('scrolled');
      } else {
          el.classList.remove('scrolled');
      }
}

window.addEventListener("resize", function() {
  addFilterBG( filterSection)
  // console.log(filterSectionHeight)

})

window.addEventListener("load", function(e) {
  addFilterBG(filterSection)
})

window.addEventListener('scroll', function(e) {
  addFilterBG(filterSection)
})

function loadThumbnail(selector) {
  for (let thumbnail of selector){
    thumbnail.innerHTML = `<img src="./images/specific_pets/pomeranian_gallery_sqaure_550_550.jpg" alt="" class = "img-fluid">`;
  }
}

const gallery = new Glider(document.querySelector('.glider-gallery-view'), {
  slidesToShow: 1,
  dots: '.thumbnail',
  draggable: true,
  dragVelocity: 2,
  scrollLock: true,
  resizeLock: true,
  arrows: {
    prev: '#thumbnail-glider-prev',
    next: '#thumbnail-glider-next'
  }, 
});


const thumbnails = gallery.dots.children;

loadThumbnail(thumbnails)

window.addEventListener("resize", function() {
  loadThumbnail(thumbnails)
})

const carousel = new Glider(document.querySelector('.glider-other-products'), {
  slidesToShow: 3,
  slidesToScroll: 1,
  draggable: true,
  dots: '.dots',
  arrows: {
    prev: '#other-products-prev',
    next: '#other-products-next'
  },
  dragVelocity: 2,
  scrollLock: true,
  resizeLock: true,
  rewind: true,

  responsive: [
      {
        breakpoint: 0,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },

      {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
      },
      
      {
          breakpoint: 992,
          settings: {
              slidesToShow: 3,
              slidesToScroll: 1
          }
      },

      {
        breakpoint: 1400,
        settings: {
            slidesToShow: 4,
            slidesToScroll: 1
        }
    }

  ]
});



