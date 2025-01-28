function showPassword(){
    document.querySelector('.form--visibility-show').classList.add('form--visibility-none');
    document.querySelector('.form--visibility-hide').classList.remove('form--visibility-none');
    document.querySelector('#password').type = "text";
}

function hidePassword(){
    document.querySelector('.form--visibility-hide').classList.add('form--visibility-none');
    document.querySelector('.form--visibility-show').classList.remove('form--visibility-none');
    document.querySelector('#password').type = "password";
}

function passwordCheck(){
    let password = document.querySelector('#password').value;

    if(password.match(/[a-z]/)){
        document.querySelector('.form--klein').classList.add('form--highlight');
    } else {
        document.querySelector('.form--klein').classList.remove('form--highlight');
    }

    if(password.match(/[A-Z]/)){
        document.querySelector('.form--gross').classList.add('form--highlight');
    } else {
        document.querySelector('.form--gross').classList.remove('form--highlight');
    }

    if(password.match(/\d/)){
        document.querySelector('.form--zahl').classList.add('form--highlight');
    } else {
        document.querySelector('.form--zahl').classList.remove('form--highlight');
    }

    if(password.match(/[^a-zA-Z\d]/)){
        document.querySelector('.form--sonder').classList.add('form--highlight');
    } else {
        document.querySelector('.form--sonder').classList.remove('form--highlight');
    }
}