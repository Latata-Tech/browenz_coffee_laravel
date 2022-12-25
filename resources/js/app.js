import './bootstrap';
import '../css/app.css'

window.deleteModal = function (elm, id) {
    let formElement = document.getElementById(id);
    formElement.action = elm.getAttribute('data');
}

window.cancelDeleteModal = function (elm, id) {
    let formElement = document.getElementById(id);
    formElement.action = '';
}