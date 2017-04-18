(function() {
    var searchText = getParameterByName('text');

    var nurls = document.getElementsByClassName('nurl-container');

    console.log('search: ' + searchText);

    for(var i=0; i<nurls.length; i++) {
        var inner = nurls[i].innerHTML;
        inner = inner.replace(new RegExp(searchText, 'g'), '<span class="hl">' + searchText + '</span>');
        nurls[i].innerHTML = inner;
    }
})();

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
