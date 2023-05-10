const baseURL = "https://f7c4-2404-8000-1046-90-7d7a-eb61-9209-c267.ngrok-free.app";


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

$('#date_filter').on('change', function () {
    $('#form_date_filter').submit()
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

function getStockType(elm) {
    $.ajax({
        url: baseURL + '/ingredients/detail-json/' + elm.value,
        method: 'get'
    }).then((value) => {
        elm.parentNode.parentNode.parentNode.children[1].children[1].children[1].innerText = value.type.name
    })
}

function addIngredient() {
    const node = document.getElementById('first').cloneNode(true);
    const elm = document.createElement('span');
    elm.className = "material-icons text-danger"
    elm.style = "cursor: pointer";
    elm.innerText = "close";
    elm.addEventListener('click', removeIngredientHtml)
    node.classList.remove("d-none");
    node.children[0].children[1].children[1].append(elm);
    node.children[0].children[1].children[1].children[0].value = '';
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
            url: baseURL + '/menus/get-menu/' + $(this).val()
        }).then(value => {
            $('#hot_price_before').val(new Intl.NumberFormat("id-ID").format(value.hot_price));
            $('#ice_price_before').val(new Intl.NumberFormat("id-ID").format(value.ice_price));
        })
    } else {
        $('#hot_price_before').val(0);
        $('#ice_price_before').val(0);
    }
});


// Transaction Stock

function addTransactionStock() {
    let transactionDate = $('#transaction_stock').val();
    let typeTransaction = $('#type_transaction').val();
    let description = $('#description').val();
    const ingredients = [];
    document.getElementsByName('ingredient_id').forEach((val, key) => {
        ingredients.push({id: val.value, qty:document.getElementsByName('qty')[key].value })
    })
    $.ajax({
        url: baseURL + '/transactions',
        data: {
            date: transactionDate,
            type: typeTransaction,
            ingredients,
            description
        },
        method: 'post',
        success: function (data) {
            console.log(data);
        }
    })
}

function trigerLogout() {
    $('#btnLogout').click();
}

function typeFilter(e) {
    if(e.value === 'daily') {
        $('#daily').removeClass('d-none');
        if(!$('#monthly').hasClass('d-none') || !$('#yearly').hasClass('d-none')) {
            $('#monthly').addClass('d-none');
            $('#yearly').addClass('d-none');
        }
    } else if(e.value === 'monthly') {
        $('#monthly').removeClass('d-none');
        $('#monthly-yearly').removeClass('d-none');
        $('#yearly').removeClass('d-none');
        if(!$('#daily').hasClass('d-none')) {
            $('#daily').addClass('d-none');
        }
    } else if(e.value === 'yearly') {
        $('#yearly').removeClass('d-none');
        $('#monthly-yearly').removeClass('d-none');
        if(!$('#daily').hasClass('d-none') || !$('#monthly').hasClass('d-none')) {
            $('#daily').addClass('d-none');
            $('#monthly').addClass('d-none');
        }
    }
}
function typeReport(e) {
    if(e.value === 'stock_transaction') {
        $('#typeTransaction').removeClass('d-none');
    } else {
        $('#typeTransaction').addClass('d-none');
    }
    document.getElementById('getReport').action = `${baseURL}/reports/${e.value === 'stock_transaction' ? 'ingredient-report' : 'selling-report'}`
}
function filterTransaction(e) {
    $('#filter-transaction').empty();
    if(e.value === "monthly") {
        const monthNames = [ "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember" ];
        for(let i = 0; i < monthNames.length; i++) {
            $('#filter-transaction').append(`<option value="${i+1}">${monthNames[i]}</option>`);
        }
    } else if(value === "yearly") {
        let currentYear = new Date().getFullYear();
        for(let i = currentYear; i > currentYear-5; i--) {
            $('#filter-transaction').append(`<option value="${i}">${i}</option>`);
        }
    }
}
