const menu = document.querySelector("#menu");

const sidebar = document.querySelector(".sidebar");

const dropdown = document.querySelector(".__dropdown");

menu.addEventListener("click", function () {
  sidebar.classList.toggle("show-sidebar");
});

dropdown.addEventListener("click", function () {
    dropdown.classList.toggle("show-dropdown");
});
