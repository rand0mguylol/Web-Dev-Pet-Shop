const filterSection= document.querySelector('.search-section');
const filterSectionMargin = parseFloat(window.getComputedStyle(filterSection).getPropertyValue("margin-top"))
const filterPrevious = filterSection.previousElementSibling;
// const filterPreviousGap = filterPrevious.offsetTop + filterPrevious.offsetHeight + 5;
// const filterSectionHeight = filterPreviousGap + filterSectionMargin;

// console.log(filterSectionHeight)

function addFilterBG(el) { 
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




