/*OwnOfferDetails - Drei verschiedene Formulare als Divider anzeigen */
let aktiveTeilnehmerDivider = document.querySelector('#aktiveTeilnehmer');
let ausstehendeAnfragenDivider = document.querySelector('#ausstehendeAnfragen');
let kontaktFormularDivider = document.querySelector('#kontaktFormular');
const angebotContainers = document.querySelectorAll('.angebot--eventContainer');
/* Beschriftung ändern */
const teilnehmerEntfernenButtons = document.querySelectorAll('.angebot--teilnehmer-delete');
const teilnehmerAblehnenButtons = document.querySelectorAll('.angebot--anfragen-ablehnen');
const teilnehmerAkzeptierenButtons = document.querySelectorAll('.angebot--anfragen-annehmen');
/* Select Menüs */
// const customSelect = document.querySelectorAll(".form--select-container");
const selectBtn = document.querySelectorAll(".form--select-button");
const selectedValue = document.querySelector(".form--select-value");
const optionsList = document.querySelectorAll(".form--select-option-radio");

teilnehmerEntfernenButtons.forEach((item) => {
    item.addEventListener('click', () => {
        item.innerHTML = "Entfernt!";
    });
});

teilnehmerAblehnenButtons.forEach((item) => {
    item.addEventListener('click', () => {
        item.innerHTML = "Abgelehnt!";
        item.previousElementSibling.innerHTML = "Annehmen";
    });
});

teilnehmerAkzeptierenButtons.forEach((item) => {
    item.addEventListener('click', () => {
        item.innerHTML = "Akzeptiert!";
        item.nextElementSibling.innerHTML = "Ablehnen";
    });
});

aktiveTeilnehmerDivider.addEventListener('click', () => {
    aktiveTeilnehmerDivider.classList.add('angebot--teilnehmer-list-active');
    ausstehendeAnfragenDivider.classList.remove('angebot--teilnehmer-list-active');
    kontaktFormularDivider.classList.remove('angebot--teilnehmer-list-active');
    angebotContainers.forEach((item) => {
        item.classList.add('angebot--hide');
        if(item.classList.contains("angebot--hide-first")){
            item.classList.remove('angebot--hide');
        }
    });

});

ausstehendeAnfragenDivider.addEventListener('click', () => {
    aktiveTeilnehmerDivider.classList.remove('angebot--teilnehmer-list-active');
    ausstehendeAnfragenDivider.classList.add('angebot--teilnehmer-list-active');
    kontaktFormularDivider.classList.remove('angebot--teilnehmer-list-active');
    angebotContainers.forEach((item) => {
        item.classList.add('angebot--hide');
        if(item.classList.contains("angebot--hide-second")){
            item.classList.remove('angebot--hide');
        }
    });
});

kontaktFormularDivider.addEventListener('click', () => {
    aktiveTeilnehmerDivider.classList.remove('angebot--teilnehmer-list-active');
    ausstehendeAnfragenDivider.classList.remove('angebot--teilnehmer-list-active');
    kontaktFormularDivider.classList.add('angebot--teilnehmer-list-active');
    angebotContainers.forEach((item) => {
        item.classList.add('angebot--hide');
        if(item.classList.contains("angebot--hide-third")){
            item.classList.remove('angebot--hide');
        }
    });
});

function openPopupBearbeiten(){
    $('#angebotBearbeitenPopup').fadeIn('slow');
    $('#angebotLehrerOverlay').fadeIn();
}

function closePopupBearbeiten(){
    $('#angebotBearbeitenPopup').fadeOut('slow');
    $('#angebotLehrerOverlay').fadeOut();
}

function openPopupLoeschen(){
    $('#angebotLoeschenPopup').fadeIn('slow');
    $('#angebotLehrerOverlay').fadeIn();
}

function closePopupLoeschen(){
    $('#angebotLoeschenPopup').fadeOut('slow');
    $('#angebotLehrerOverlay').fadeOut();
}

function openPopupKontakt(){
    $('#kontaktBearbeitenPopup').fadeIn('slow');
    $('#angebotLehrerOverlay').fadeIn();
}

function closePopupKontakt(){
    $('#kontaktBearbeitenPopup').fadeOut('slow');
    $('#angebotLehrerOverlay').fadeOut();
}

selectBtn.forEach((item) => {
    item.addEventListener("click", () => {
        customSelect = item.parentElement;
        customSelect.classList.toggle("active");
        item.setAttribute(
            "aria-expanded",
            selectBtn.getAttribute("aria-expanded") === "true" ? "false" : "true"
        );
    });
});

optionsList.forEach((option) => {
    function handler(e) {
        if (e.type === "click" && e.clientX !== 0 && e.clientY !== 0 ) {
            selectedValue.textContent = this.children[1].textContent;
            customSelect.classList.remove("active");
        }
        if (e.key === "Enter") {
            selectedValue.textContent = this.textContent;
            customSelect.classList.remove("active");
        }
    }

    option.addEventListener("keyup", handler);
    option.addEventListener("click", handler);
});

function backToOverview(){
    window.location = 'https://cinnec.de/angeboteLehrer';
}