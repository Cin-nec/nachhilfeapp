let slider = document.querySelector('#profilKlasse');
let output = document.querySelector('#profilSliderValue');
output.innerHTML = slider.value;

slider.oninput = function () {
    output.innerHTML = this.value;
}