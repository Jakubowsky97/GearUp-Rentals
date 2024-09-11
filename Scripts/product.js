function validateForm() {
    var startDate = new Date(document.getElementById("dataPocz").value);
    var endDate = new Date(document.getElementById("dataKonc").value);
    var today = new Date();

    if (startDate >= endDate) {
        alert("Data rozpoczęcia musi być wcześniejsza niż data zakończenia.");
        return false;
    }
    
    if (startDate < today) {
        alert("Data rozpoczęcia nie może być wcześniejsza niż dzisiejsza data.");
        return false;
    }

    return true;
}   

var MainImg = document.getElementById("MainImg");
var SmallImg = document.getElementsByClassName("small-img");

for(let i = 0; i < SmallImg.length; i++) { 
    SmallImg[i].onclick = function() { 
        MainImg.src = SmallImg[i].src;
    }
}