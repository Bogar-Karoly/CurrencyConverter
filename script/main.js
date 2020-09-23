/*
* Note: "I could use javascript for the exchange too, so everything could be on the client side. But there are security reasons, so I choose to not to do.
* Or it could have been done by the server."
*/

// api request for currency types
const url = 'https://openexchangerates.org/api/currencies.json';
fetch(url).then(function(response) {
    response.text().then(function(text) {

        let json = JSON.parse(text);

        let from = document.getElementById('selectFrom');
        let to = document.getElementById('selectTo');

        for(let key in json) {
            addOption(from, key, json[key]);
            addOption(to, key, json[key]);
        }
    });
});

// add Options to select element
function addOption(parent, index, item) {
    let element = document.createElement('option');

    element.value = index;
    element.innerHTML = item;
    parent.appendChild(element);
}
// result bar
function Dropbar () {
    let dropbox = document.getElementById('resultBox');
    dropbox.style.maxHeight = dropbox.scrollHeight + "px";
}
// Swap input value
function Swapping () {
    let From = document.getElementById('inputFrom');
    let To = document.getElementById('inputTo');

    let temp = From.value;
    From.value = To.value;
    To.value = temp;
}
// result
function Result (post) {
    let result = String(JSON.parse(post));
    let resultBox = document.getElementById('resultBox');
    resultBox.innerHTML = 'Result: ' + result + ' ' + document.getElementById('inputTo').value;
    Dropbar();
}