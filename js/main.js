// api request for currency types
const url = 'https://openexchangerates.org/api/currencies.json';
const currencies = document.getElementById('currencies');
const from = document.getElementById('selectFrom');
const to = document.getElementById('selectTo');
const form = document.getElementById('exchange-form');
const resultBox = document.getElementById('resultBox');

const input = {
    from: form.querySelector('input[name="from"]'),
    to: form.querySelector('input[name="to"]'),
    value: form.querySelector('input[name="value"]'),
}

const templates = {
    currency_tmpl: document.getElementById('currency-template').content.querySelector('.currency'),
}
form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(form);
    const url = new URL('http://localhost/currencyconverter/api/?api=calculate');
    for (const [key, value] of formData.entries()) {
        url.searchParams.append(key, value);
    }
    resetErrorFields();
    resultBox.innerText = '';

    const response = await sendRequest(url);

    if(response !== false && 'converted' in response && response.converted !== '') {
        resultBox.innerText = response.converted;
        return;
    }
    alert(response);
});

function resetErrorFields() {
    const fields = document.querySelectorAll('.field-error');
    if(fields !== null)
        fields.forEach(e => { e.innerHTML = ''; });
}

function sendRequest(url) {
    return fetch(url, {
        method: 'get',
    }).then((response) => { 
        return response.json(); 
    }).then((response) => {
        if('success' in response && response.success === true) {
            return response;
        }
        if('error' in response) {
            const input_field = document.querySelector(`input[name="${response.error.type}"]`);
            if(input_field !== null) {
                input_field.parentElement.querySelector('.field-error').innerText = response.error.info;
            }
        }
        return false;
    }).catch((error) => {
        alert(error);
        return false;
    });
}

window.addEventListener('load', async (event) => {
    event.preventDefault();
    await fetch('api/?api=getCurrencies').then(response => response.json()).then(records => {
        if(records !== '') {
            records.forEach(e => {
                const tmpl = templates.currency_tmpl.cloneNode(true);
                tmpl.querySelector(".short_name").innerText = `${e.short_name}`;
                tmpl.querySelector(".name").innerText = `${e.name}`;
                tmpl.querySelector(".value").innerText = e.value;
                currencies.appendChild(tmpl);

                addOption(from, e.short_name, e.name);
                addOption(to, e.short_name, e.name);
            });
        }
    });

});

// add Options to select element
function addOption(parent, index, item) {
    const element = document.createElement('option');
    element.value = index;
    element.innerHTML = item;
    parent.appendChild(element);
}
// Swap input value
function Swapping () {
    let From = document.getElementById('inputFrom');
    let To = document.getElementById('inputTo');

    const temp = input.from.value;
    input.from.value = input.to.value;
    input.to.value = temp;
}