/*
Variable and constant declaration
*/
const NOT_DELETE_ALL = 0;
const IS_DELETE_ALL = 1;
const CART_IDS = 'cart.ids';
const CART_CHECK_ALL = 'cart.delete.all';

$.urlParam = function(name){
    let results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
        return null;
    }
    else{
        return decodeURI(results[1]);
    }
};

/*
Commons modules
*/
let Commons = (function ($) {

    let modules = {};

    modules.setLocalStorageListIds = function ($key, $value) {
        localStorage.setItem($key, JSON.stringify($value));
    };

    modules.setLocalStorageDeleteAll = function ($key, $value) {
        localStorage.setItem($key, $value);
    };

    modules.getArrayValueLocalStorage = function (key) {
        let $value = [];

        if (JSON.parse(localStorage.getItem(key))) {
            $value = JSON.parse(localStorage.getItem(key));
        }

        return $value;
    };

    modules.getSingleValueLocalStorage = function (key) {
        let $value = NOT_DELETE_ALL;

        if (localStorage.getItem(key)) {
            $value = localStorage.getItem(key);
        }

        return $value;
    };

    modules.removeLocalStorage = function ($key) {
        localStorage.removeItem($key);
    };

    return modules;

}(window.jQuery, window, document));

$(document).ready(function () {

    function preventEnter(ev) {
        if ((ev.which && ev.which === 13) || (ev.keyCode && ev.keyCode === 13)) {
            return false;
        } else {
            return true;
        }
    }

    let inputArr = [
        "input[type=text]", "input[type=email]",
        "input[type=password]", "input[type=url]",
        "input[type=datetime]", "input[type=date]",
        "input[type=month]", "input[type=week]",
        "input[type=time]", "input[datetime-local]",
        "input[number]", "input[range]", "input[radio]"
    ];
    inputArr.forEach(e => $(e).keypress(preventEnter));
});
