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

window.price = function (elm) {
    let value = elm.value;
    if(value.includes('.')) {
        value = value.split('.').join('');
    }
    elm.value = new Intl.NumberFormat("id-ID").format(value)
}

window.undisabled = function (chk, targetId) {
    if(chk.checked) document.getElementById(targetId).removeAttribute("disabled");
    else document.getElementById(targetId).setAttribute("disabled", "disabled");
}

window.$ = $;

$('#searchData').on('search', function (evt) {
    $('#formSearch').submit();
})

$('#photo').on('change', function (evt) {
    const [file] = document.getElementById('photo').files
    if(file) {
        const prevImage = document.getElementById('previewImage');
        prevImage.src = URL.createObjectURL(file);
        prevImage.height = 160;
        prevImage.width = 137;
    }
})

function removeIngredient(elm) {
    elm.parentNode.remove();
}

$('#addIngredient').on('click', function () {
    const options = document.getElementById('ingredient_id[]').options;
    const selectedOptions = [];
    document.getElementsByName('ingredient_id[]').forEach((val, i) => {
        selectedOptions.push(val.selectedOptions[0].value);
    });
    let selectElm = `<select class='form-control' name="ingredient_id[]">`;
    for(let i = 0; i < options.length; i++) {
        selectElm+=options[i].outerHTML;
    }
    selectElm += "</select>";
    $('#ingredientsContainer').append(`<div class="mb-2 d-flex justify-content-center align-items-center">${selectElm}<span class="material-icons text-danger" onclick="removeIngredient(this)" style="cursor: pointer">close</span></div>`)
})
