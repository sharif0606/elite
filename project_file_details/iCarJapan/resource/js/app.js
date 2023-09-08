// review section

const topHightlight = document.querySelector(".top-hlights");
const disLight = document.querySelector(".dis-lights");

topHightlight.addEventListener("click", function () {
  disLight.style.display = "block";
  topHightlight.style.display = "none";
});

disLight.addEventListener("click", function () {
  disLight.style.display = "none";
  topHightlight.style.display = "block";
});

// product galary

const mainImg = document.getElementById("main-img");
const smImg = document.getElementsByClassName("sm-img");

smImg[0].onclick = function () {
  mainImg.src = smImg[0].src;
};
smImg[1].onclick = function () {
  mainImg.src = smImg[1].src;
};
smImg[2].onclick = function () {
  mainImg.src = smImg[2].src;
};
smImg[3].onclick = function () {
  mainImg.src = smImg[3].src;
};
smImg[4].onclick = function () {
  mainImg.src = smImg[4].src;
};
