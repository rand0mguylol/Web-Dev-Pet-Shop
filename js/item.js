  const thumb = JSON.parse(thumbjson);
    // console.log(thumb)
    function loadThumbnail(thumbnailArray, selector) {
        for (let i = 0; i < thumbnailArray.length; i++) {
            selector[i].innerHTML = `<img src="${thumbnailArray[i].imagePath}" alt="" class = "img-fluid">`;
        }
    }
    const carousel = new Glider(document.querySelector('.glider-other-products'), {
        slidesToShow: 3,
        slidesToScroll: 1,
        // Allow user to drag the carousel
        draggable: true,
        dots: '.dots',
        arrows: {
            prev: '#other-products-prev',
            next: '#other-products-next'
        },
        dragVelocity: 2,
        scrollLock: true,
        resizeLock: true,
        // Goes to the beginning of the carousel when user reach the end
        rewind: true,

        // The amount of slides to display at once, dependant on the screen size
        responsive: [{
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
        eventPropagate: false,
    });
    thumbnailsButton = gallery.dots.children;
    loadThumbnail(thumb, thumbnailsButton)
    window.addEventListener("resize", function() {
        loadThumbnail(thumb, thumbnailsButton);
    })