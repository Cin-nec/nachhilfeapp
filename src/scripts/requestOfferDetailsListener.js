/* Anfrage abbrechen Button */
let overlay = $('#angebotOffenOverlay');
let abbrechenPopup = $('#angebotAbbrechenPopup');

function openPopupAbbrechen(){
    abbrechenPopup.fadeIn('slow');
    overlay.fadeIn();
}

function closePopupAbbrechen(){
    abbrechenPopup.fadeOut('slow');
    overlay.fadeOut();
}