let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bx-search");
var delayInMilliseconds = 10000; //1 second


closeBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("open");
});

