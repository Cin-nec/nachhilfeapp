document.querySelectorAll('.nav--heading').forEach((item) => {
    item.addEventListener('click', () => {
        window.location = 'https://cinnec.de/home';
    })
})

document.querySelectorAll('.icon--button-profil').forEach((item) => {
    item.addEventListener('click', () => {
        window.location = 'https://cinnec.de/profil';
    })
})

function openPopupToggle(){
    $('#toggleView').fadeIn('slow');
    $('#angebotLehrerOverlay').fadeIn();
}

function closePopupToggle(){
    $('#toggleView').fadeOut('slow');
    $('#angebotLehrerOverlay').fadeOut();
}

function openPopupSubNavToggle(){
    $('#toggleSubNavView').fadeIn('slow');
    $('#angebotLehrerOverlay').fadeIn();
}

function closePopupSubNavToggle(){
    $('#toggleSubNavView').fadeOut('slow');
    $('#angebotLehrerOverlay').fadeOut();
}