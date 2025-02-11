/* Nachhilfe anfragen Button */
let overlay = $('#angebotOffenOverlay');
let anfragenPopup = $('#angebotBeendenPopup');

function openPopupBeenden(){
    anfragenPopup.fadeIn('slow');
    overlay.fadeIn();
}

function closePopupBeenden(){
    anfragenPopup.fadeOut('slow');
    overlay.fadeOut();
}

function backToOverview(){
    window.location = 'https://cinnec.de/angeboteGebucht';
}