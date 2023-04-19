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

function removeIngredientHtml() {
    this.parentNode.parentNode.parentNode.parentNode.removeChild((this.parentNode.parentNode.parentNode));
}

function addIngredient() {
    const node = document.getElementById('first').cloneNode(true);
    const elm = document.createElement('span');
    elm.className = "material-icons text-danger"
    elm.style = "cursor: pointer";
    elm.innerText = "close";
    elm.addEventListener('click', removeIngredientHtml)
    node.children[0].children[1].children[1].append(elm);
    document.getElementById('ingredients_container').appendChild(node);
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

$('#menu_id').on('change', function () {
    if($(this).val() !== '-') {
        $.ajax({
            url: 'https://46f3-2404-8000-1046-90-f0e3-b654-9e60-9445.ngrok-free.app/menus/get-menu/' + $(this).val()
        }).then(value => {
            $('#hot_price_before').val(new Intl.NumberFormat("id-ID").format(value.hot_price));
            $('#ice_price_before').val(new Intl.NumberFormat("id-ID").format(value.ice_price));
        })
    } else {
        $('#hot_price_before').val(0);
        $('#ice_price_before').val(0);
    }
});
