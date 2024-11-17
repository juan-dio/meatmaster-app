const hamburger = document.querySelector('.hamburger-menu');
const linkList = document.querySelector('.link-list');

hamburger.addEventListener('click', function() {
  linkList.classList.toggle('link-list-active');
  hamburger.classList.toggle('hamburger-active');
});
