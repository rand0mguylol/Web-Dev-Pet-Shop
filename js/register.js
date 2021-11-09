//Get ViewPassword Button and password field
const password = document.querySelector("#registerPassword")
const viewPasswordBtn = document.querySelector(".view-Password");
//View password
viewPasswordBtn.addEventListener("change",function(){
  if(this.checked){
    password.type = "text";
  }else{
    password.type = "password";
  }
})