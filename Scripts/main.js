
// pobranie aktualnego adresu URL
var currentUrl = window.location.href;

// pobranie wszystkich hiperłączy na stronie
var links = document.getElementsByClassName("primary-navigation-item");

// iterowanie przez wszystkie hiperłącza
for (var i = 0; i < links.length; i++) {
  // pobranie adresu URL każdego hiperłącza
  var linkUrl = links[i].href;

  // porównanie adresu URL hiperłącza z aktualnym adresem URL
  if (linkUrl === currentUrl) {
    links[i].style.color = "#237f8a";
  }
}


// Gdy użytkownik przewinie stronę, uruchom funkcje
window.onscroll = function() {myFunction()};

// Zbierz navbar
var navbar = document.getElementById("navbar");
var nav = document.getElementsByTagName("nav");

// Uzyskaj przesunięcie pozycji paska nawigacyjnego
var sticky = navbar.offsetTop;

// Dodaj klasę sticky do paska nawigacyjnego, gdy osiągniesz pozycję przewijania. Usuń „sticky” po opuszczeniu pozycji przewijania
function myFunction() {
  if (window.scrollY > sticky) {
    navbar.classList.add("sticky");
  } else {
    navbar.classList.remove("sticky");
  }
}




//funkcja pokazująca i ukrywająca hasło podczas kliknięcia napisu
function showPassword() {
  var passwordInput = document.getElementById("password-input");
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
  } else {
    passwordInput.type = "password";
  }
}

function enableSubmit() {
  // Pobranie wszystkich elementów formularza o klasie 'required'
  let inputs = document.getElementsByClassName('required');
  // Pobranie przycisku typu 'submit'
  let btn = document.querySelector('input[type="submit"]');
  // Zmienna przechowująca informację o poprawności wszystkich pól
  let isValid = true;
  
  // Iteracja przez wszystkie pola formularza
  for (let i = 0; i < inputs.length; i++) {
    let changedInput = inputs[i];
    // Sprawdzenie, czy pole jest puste lub niezdefiniowane
    if (changedInput.value.trim() === "" || changedInput.value === null) {
      // Jeśli pole jest puste, ustaw flagę isValid na false i przerwij pętlę
      isValid = false;
      break;
    }
  }
  
  // Sprawdzenie, czy wszystkie wymagane pola są wypełnione i czy ich liczba wynosi 3
  if (isValid) {
    // Jeśli tak, odblokuj przycisk
    btn.disabled = false;
    // Wyświetl komunikat w konsoli
    console.log("Wszystkie pola są wypełnione.");

    btn.style.opacity = "0.75";
    btn.style.backgroundColor = "#A98743"; 
    btn.style.border = "#A98743";
    btn.style.cursor = "pointer";
  } else {
    // Jeśli jakiekolwiek pole jest puste lub liczba pól jest inna niż 3, zablokuj przycisk
    btn.disabled = true;
    // Wyświetl komunikat w konsoli
    console.log("Nie wszystkie pola są wypełnione.");
    // Usuń kolor tła przycisku
    btn.style.backgroundColor = ""; 
    btn.style.opacity = "0.25";
    btn.style.cursor = ""
  }
}


function openMobileMenu() {
  var x = document.getElementsByClassName("mobile-navigation-items")[0];
  if (!x.classList.contains('nav-open')) {
    x.classList.add('nav-open');
    x.classList.remove('nav-close'); // Usuwamy klasę nav-close, jeśli istnieje
    disableScroll();
  } else {
    x.classList.add('nav-close'); // Dodajemy klasę nav-close
    x.classList.remove('nav-open');
    enableScroll();
  }
}

function disableScroll() {
  // Get the current page scroll position in the vertical direction
 scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      
      
// Get the current page scroll position in the horizontal direction 

scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
 
 
// if any scroll is attempted,
// set this to the previous value
window.onscroll = function() {
window.scrollTo(scrollLeft, scrollTop);
};
}

function enableScroll() {
   window.onscroll = function() {};
}
