var modal = document.getElementById('myModal');
var modalImg = document.getElementsByClassName("modal-content")[0];
var closeBtn = document.getElementsByClassName("modal-close-btn")[0];
var isModalShown = sessionStorage.getItem('isModalShown');

if (isModalShown != "true") {
  modal.style.display = "block"; 
  // Do not show modal again in the same session
  sessionStorage.setItem('isModalShown', true);
}

function closeModal() {
  modal.style.display = "none";
}

closeBtn.onclick = function() {
  closeModal();
}

modalImg.onclick = function() {
  closeModal();
}

modal.onclick = function() {
  closeModal();
}
// close modal on Esc key press
document.onkeydown = function(evt) {
  evt = evt || window.event;
  var isEscape = false;
  if ("key" in evt) {
    isEscape = (evt.key === "Escape" || evt.key === "Esc");
  } else {
    isEscape = (evt.keyCode === 27);
  }
  if (isEscape) {
    closeModal();
  }
};
