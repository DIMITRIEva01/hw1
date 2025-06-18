
//barra ricerca a scomparsa
const ricercaBtn = document.getElementById("ricerca");
const barraRicerca = document.getElementById("barra-ricerca");
const menu = document.getElementById("menu");
const menuMobile = document.querySelector(".menu-mobile");

ricercaBtn.addEventListener("click", function(event) {
  event.stopPropagation();
  menu.style.display = "none";
  menuMobile.style.display = "none";
  ricercaBtn.style.display = "none";
  barraRicerca.style.display = "flex";
});

document.addEventListener("click", function(event) {
  if (barraRicerca.style.display === "flex" && !barraRicerca.contains(event.target)) {
    menu.style.display = "flex";
    ricercaBtn.style.display = "flex";
    barraRicerca.style.display = "none";
  }
});

barraRicerca.addEventListener("click", function(event) {
  event.stopPropagation();
});


//modale servizio clienti
const openModalBtn = document.getElementById("open-modal");
const closeModalBtn = document.getElementById("close-modal");
const modal = document.getElementById("modale1");

openModalBtn.addEventListener("click", openModale);
closeModalBtn.addEventListener("click", closeModale);

function openModale() {
  console.log("Modal SC opened");
  modal.style.display = "flex";
}

function closeModale() {
  console.log("Modal SC closed");
  modal.style.display = "none";
}
//modale carrello-header
const openModalcarrelloheader = document.getElementById("carrello-header");
const closeModalcarrelloheader = document.getElementById("close-modal2");
const modalcarrelloheader = document.getElementById("modale2");

openModalcarrelloheader.addEventListener("click", openModale2);
closeModalcarrelloheader.addEventListener("click", closeModale2);

function openModale2() {
  modalcarrelloheader.style.display = "flex";
}

function closeModale2() {
  modalcarrelloheader.style.display = "none";
}
//modale carrello-mobile
const openModalcarrello = document.getElementById("carrello");
const closeModalcarrello = document.getElementById("close-modal2");
const modalcarrello = document.getElementById("modale2");

openModalcarrello.addEventListener("click", openModale2);
closeModalcarrello.addEventListener("click", closeModale2);

function openModale2() {
  modalcarrello.style.display = "flex";
}

function closeModale2() {
  modalcarrello.style.display = "none";
}
//modale menu-mobile
const openModalmenu = document.getElementById("open-modal-menu");
const closeModalmenu = document.getElementById("close-modal-menu");
const modalmenu = document.getElementById("modale-menu");

openModalmenu.addEventListener("click", openModale3);
closeModalmenu.addEventListener("click", closeModale3);

function openModale3() {
  modalmenu.style.display = "flex";
}

function closeModale3() {
  modalmenu.style.display = "none";
}

//scroll 1

const container = document.getElementById("manga-container");
const btnLeft = document.getElementById("btn_left");
const btnCenter = document.getElementById("btn_center");
const btnRight = document.getElementById("btn_right");

function resetButtons() {
  btnLeft.classList.remove("active");
  btnCenter.classList.remove("active");
  btnRight.classList.remove("active");
}

btnLeft.onclick = function () {
  resetButtons();
  btnLeft.classList.add("active");
  container.scrollLeft = 0; 
};

btnCenter.onclick = function () {
  resetButtons();
  btnCenter.classList.add("active");
  container.scrollLeft = 920;
};

btnRight.onclick = function () {
  resetButtons();
  btnRight.classList.add("active");
  container.scrollLeft = 2000; 
};
// scroll 2
const container2 = document.getElementById("manga-container2");
const btnLeft2 = document.getElementById("btn_left2");
const btnCenter2 = document.getElementById("btn_center2");    
const btnRight2 = document.getElementById("btn_right2");
function resetButtons2() {
  btnLeft2.classList.remove("active");
  btnCenter2.classList.remove("active");
  btnRight2.classList.remove("active");
}
btnLeft2.onclick = function () {
  resetButtons2();
  btnLeft2.classList.add("active");
  container2.scrollLeft = 0;
};
  btnCenter2.onclick = function () {
  resetButtons2();
  btnCenter2.classList.add("active");
  container2.scrollLeft = 920;
};
btnRight2.onclick = function () {
  resetButtons2();
  btnRight2.classList.add("active");
  container2.scrollLeft = 2000;
};

// scroll 3
const container3 = document.getElementById("manga-container3"); 
const btnLeft3 = document.getElementById("btn_left3");
const btnCenter3 = document.getElementById("btn_center3");
const btnRight3 = document.getElementById("btn_right3");
function resetButtons3() {
  btnLeft3.classList.remove("active");
  btnCenter3.classList.remove("active");
  btnRight3.classList.remove("active");
} 
btnLeft3.onclick = function () {
  resetButtons3();
  btnLeft3.classList.add("active");
  container3.scrollLeft = 0;
};
btnCenter3.onclick = function () {
  resetButtons3();
  btnCenter3.classList.add("active");
  container3.scrollLeft = 920;
};
btnRight3.onclick = function () {
  resetButtons3();
  btnRight3.classList.add("active");
  container3.scrollLeft = 2000;
};

//home image
var homeImage = document.getElementById("home-image");

homeImage.onmouseover = function () {
  homeImage.style.backgroundImage = "url('efc880bfd286285695625a9aa1de4ed8.jpg')";
};

homeImage.onmouseout = function () {
  homeImage.style.backgroundImage = "url('9680c4d992809617a2f474a4435c687c.jpg')";
};


