    const url = 'https://openexchangerates.org/api/currencies.json';
    fetch(url).then(function(response) {
        response.text().then(function(text) {

            var json = JSON.parse(text);

            var from = document.getElementById('selectFrom');
            var to = document.getElementById('selectTo');

            for(var key in json) {
                //console.log(key);
                addOption(from, key, json[key]);
                addOption(to, key, json[key]);

            }
        });
    });

    function addOption(parent, index, item) {
        let element = document.createElement('option');

        element.value = index;
        element.innerHTML = index +' - '+ item;
        parent.appendChild(element);
    }