/* Nachhilfe anfragen Button */
let overlay = $('#angebotOffenOverlay');
let anfragenPopup = $('#angebotAnfragenPopup');

function openPopupAnfragen(){
    anfragenPopup.fadeIn('slow');
    overlay.fadeIn();
}

function closePopupAnfragen(){
    anfragenPopup.fadeOut('slow');
    overlay.fadeOut();
}

function backToOverview(){
    window.location = 'https://cinnec.de/angeboteOffen'
}