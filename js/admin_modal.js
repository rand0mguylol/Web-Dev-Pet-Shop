window.addEventListener("load", function(){
    modal = document.querySelector("#editProductModal")
    if(modal){
        setTimeout(() => {
            modal.classList.toggle("show")
            modal.style.display = "block"
        }, 200);
    closeModal = document.querySelector(".closeEditProductModal")
    closeModal.addEventListener("click", function(){
        modal.classList.toggle("show")
        modal.style.display = "none"
    })
    }
  
})