/* Beschriftung ändern */
const teilnehmerEntfernenButtons = document.querySelectorAll('.angebot__teilnehmer-delete');
const teilnehmerAblehnenButtons = document.querySelectorAll('.angebot__anfragen-ablehnen');
const teilnehmerAkzeptierenButtons = document.querySelectorAll('.angebot__anfragen-annehmen');
/* Select Menüs */
// const customSelect = document.querySelectorAll(".form--select-container");
const selectBtn = document.querySelectorAll(".form--select-button-radio");
const selectedValue = document.querySelector(".form--select-value-radio");
const optionsList = document.querySelectorAll(".form--select-option-radio");

/* Select Menüs für Filter */
const selectBtnFilter = document.querySelectorAll(".form--select-button-filter");
const selectedValueFilter = document.querySelectorAll(".form--select-value-filter");
const optionsListFilter = document.querySelectorAll(".form--select-option-filter");

/* Select Menüs für Checkboxen */
const selectBtnCheck = document.querySelectorAll(".form--select-button-check");
const selectedValueCheck = document.querySelector(".form--select-value-check");
const optionsListCheck = document.querySelectorAll(".form--select-option-check");

function openPopupErstellen(){
    $('#angebotErstellenPopup').fadeIn('slow');
    $('#angebotLehrerOverlay').fadeIn();
}

function closePopupErstellen(){
    $('#angebotErstellenPopup').fadeOut('slow');
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

// Für den Filter in den Own Offers
selectBtnFilter.forEach((item) => {
    item.addEventListener("click", () => {
        customSelectFilter = item.parentElement;
        customSelectFilter.classList.toggle("active");
        item.setAttribute(
            "aria-expanded",
            selectBtnFilter.getAttribute("aria-expanded") === "true" ? "false" : "true"
        );
    });
});

optionsListFilter.forEach((option) => {
    function handler(e) {
        if (e.type === "click" && e.clientX !== 0 && e.clientY !== 0 ) {
            selectedValueFilter[0].textContent = this.children[1].textContent;
            customSelectFilter.classList.remove("active");
        }
        if (e.key === "Enter") {
            selectedValueFilter[0].textContent = this.textContent;
            customSelectFilter.classList.remove("active");
        }
    }

    option.addEventListener("keyup", handler);
    option.addEventListener("click", handler);
});

// Für die Checkboxen(Jahrgang auswählen)
selectBtnCheck.forEach((item) => {
    item.addEventListener("click", () => {
        customSelectCheck = item.parentElement;
        customSelectCheck.classList.toggle("active");
        item.setAttribute(
            "aria-expanded",
            selectBtnCheck.getAttribute("aria-expanded") === "true" ? "false" : "true"
        );
    });
});
