const toTop = document.querySelector(".to-top");
    const subNavToggle = document.querySelectorAll(".dropdown-toggle");
    const subNavMenu = document.querySelectorAll(".dropdown-menu");
    const navCol = document.querySelector(".navbar-collapse")
    window.addEventListener("scroll", () => {
        if (window.pageYOffset > 100) {
            toTop.classList.add("active");
            for (i = 0; i < subNavToggle.length; ++i) {
                subNavToggle[i].classList.remove("show")
            };
            for (i = 0; i < subNavMenu.length; ++i) {
                subNavMenu[i].classList.remove("show")
            };
            navCol.classList.remove("show")
        } else {
            toTop.classList.remove("active");
        }
    })