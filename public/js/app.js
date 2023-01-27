window.deleteModal = function (elm, id) {
    let formElement = document.getElementById(id);
    formElement.action = elm.getAttribute('data');
}

window.cancelDeleteModal = function (elm, id) {
    let formElement = document.getElementById(id);
    formElement.action = '';
}

window.eventClearSearch = function (elm) {
    elm.addEventListener('search', (evt) => {
        console.log(elm.values)
    })
}

window.$ = $;

$('#searchData').on('search', function (evt) {
    $('#formSearch').submit();
})
