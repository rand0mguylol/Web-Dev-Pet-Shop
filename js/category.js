const filterSection= document.querySelector('.search-section');
const filterSectionMargin = parseFloat(window.getComputedStyle(filterSection).getPropertyValue("margin-top"))
const filterPrevious = filterSection.previousElementSibling;

// Set a white background for the Search Form and Filter button in category.php when they sticked to the top
function addFilterBG(el) { 
  const filterPreviousGap = filterPrevious.offsetTop + filterPrevious.offsetHeight + 5;
  const filterSectionHeight = filterPreviousGap + filterSectionMargin;
  if (window.scrollY >= filterSectionHeight) {
          el.classList.add('scrolled');
      } else {
          el.classList.remove('scrolled');
      }
}

// Call the functions again as the values used to compute when to apply the background is changed when
// these window event happens

window.addEventListener("resize", function() {
  addFilterBG( filterSection)
})

window.addEventListener("load", function(e) {
  addFilterBG(filterSection)
})

window.addEventListener('scroll', function(e) {
  addFilterBG(filterSection)
})




