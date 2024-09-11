var x, i, j, l, ll, selElmnt, a, b, c;

/* Look for any elements with the class "custom-select": */
x = document.getElementsByClassName("kategoria");
l = x.length;
for (i = 0; i < l; i++) {
    selElmnt = x[i].getElementsByTagName("select")[0];
    if (!selElmnt) {
        continue;
    }
    ll = selElmnt.length;

    /* For each element, create a new DIV that will act as the selected item: */
    a = document.createElement("DIV");
    a.setAttribute("class", "select-selected");
    a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    a.innerHTML = selElmnt.options[0].innerHTML = "Wszystko";
    x[i].appendChild(a);

    /* For each element, create a new DIV that will contain the option list: */
    b = document.createElement("DIV");
    b.setAttribute("class", "select-items select-hide");
    for (j = 0; j < ll; j++) {
        /* For each option in the original select element,
        create a new DIV that will act as an option item: */
        c = document.createElement("DIV");
        c.innerHTML = selElmnt.options[j].innerHTML;

        // Dodajemy identyfikator kategorii jako atrybut data-category-id
        c.setAttribute("data-category-id", selElmnt.options[j].value);

        c.addEventListener("click", function(e) {
            /* When an item is clicked, update the original select box,
            and the selected item: */
            var y, k, s, h;
            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
            h = this.parentNode.previousSibling;
            for (k = 0; k < s.length; k++) {
                if (s.options[k].innerHTML == this.innerHTML) {
                    s.selectedIndex = k;
                    h.innerHTML = this.innerHTML;
                    y = this.parentNode.getElementsByClassName("same-as-selected");
                    for (var i = 0; i < y.length; i++) {
                        y[i].removeAttribute("class");
                    }
                    this.setAttribute("class", "same-as-selected");
                    break;
                }
            }
            h.click();

            // Aktualizacja tekstu wybranego elementu
            var selectedOptionText = this.textContent;
            var selectSelected = this.parentNode.parentNode.querySelector(".select-selected");
            selectSelected.textContent = selectedOptionText;

            // Przekierowanie użytkownika do strony ofert z wybraną kategorią
            var selectedCategoryId = this.getAttribute("data-category-id");
            if (selectedCategoryId) {
                var baseUrl = window.location.href.split('?')[0]; // Pobranie podstawowego adresu URL
                var newUrl = baseUrl + '?kategoria=' + selectedCategoryId; // Dodanie parametru kategorii do adresu URL
                window.location.href = newUrl; // Przekierowanie do nowego adresu URL
            }
        });
        b.appendChild(c);
    }
    x[i].appendChild(b);
    a.addEventListener("click", function(e) {
        /* When the select box is clicked, close any other select boxes,
        and open/close the current select box: */
        e.stopPropagation();
        closeAllSelect(this);
        this.nextSibling.classList.toggle("select-hide");
        this.classList.toggle("select-arrow-active");
    });
}

function closeAllSelect(elmnt) {
    var selectItems = document.getElementsByClassName("select-items");
    var selectSelected = document.getElementsByClassName("select-selected");

    if (elmnt.classList.contains("select-selected") && elmnt.classList.contains("select-arrow-active")) {
        for (var i = 0; i < selectItems.length; i++) {
            if (selectItems[i] !== elmnt.nextSibling) {
                selectItems[i].classList.add("select-hide");
            }
        }
        for (var j = 0; j < selectSelected.length; j++) {
            if (selectSelected[j] !== elmnt) {
                selectSelected[j].classList.remove("select-arrow-active");
            }
        }
    } else if (!elmnt.classList.contains("select-items")) {
        for (var k = 0; k < selectItems.length; k++) {
            selectItems[k].classList.add("select-hide");
        }
        for (var l = 0; l < selectSelected.length; l++) {
            selectSelected[l].classList.remove("select-arrow-active");
        }
    }
}

document.addEventListener("click", function(event) {
    var target = event.target;

    if (target.classList.contains("select-selected") || target.classList.contains("select-arrow-active")) {
        closeAllSelect(target);
    } else if (!target.classList.contains("select-items")) {
        closeAllSelect();
    }
});

// Ustawienie wybranej kategorii na podstawie parametru "kategoria" w adresie URL
document.addEventListener("DOMContentLoaded", function() {
    var params = new URLSearchParams(window.location.search);
    var selectedCategory = params.get('kategoria');
    if (selectedCategory) {
        var selectElement = document.getElementById("kategorie"); // Załóżmy, że masz element select o id "kategorie"
        selectElement.value = selectedCategory;
        var event = new Event('change'); // Symulujemy zdarzenie zmiany wartości
        selectElement.dispatchEvent(event);
    }
});
