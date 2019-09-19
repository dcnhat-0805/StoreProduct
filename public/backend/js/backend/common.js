/*
Variable and constant declaration
*/
const NOT_DELETE_ALL = 0;
const IS_DELETE_ALL = 1;
const USER_IDS = 'users.ids';
const USER_DELETE_ALL = 'users.delete.all';
const BANNER_IDS = 'banners.ids';
const BANNER_DELETE_ALL = 'banners.delete.all';
const AGENT_IDS = 'agents.ids';
const AGENT_DELTE_ALL = 'agents.delete.all';
const CUSTOMER_IDS = 'customers.ids';
const CUSTOMER_DELETE_ALL = 'customers.delete.all';
const BAR_FAVORITE_IDS = 'bar.favorite.ids' ;
const BAR_FAVORITE_DELETE_ALL = 'bar.favorite.delete.all' ;
const BAR_FAVORITE_EDIT_ADD_IDS = 'bar.favorite.edit.add.ids' ;
const BAR_FAVORITE_EDIT_REMOVE_IDS = 'bar.favorite.edit.remove.ids' ;
const BAR_FAVORITE_EDIT_IDS = 'bar.favorite.edit.ids' ;
const BAR_FAVORITE_EDIT_DELETE_ALL = 'bar.favorite.edit.delete.all' ;
const MAILSERVICE_IDS = 'mail_service.ids';
const MAILSERVICE_DELETE_ALL = 'mail_service.delete.all';
const APPLYMAIL_IDS = 'applyMail.ids';
const APPLYMAIL_DELETE_ALL = 'applyMail.delete.all';
const URL_AGENT_REGISTER = '/admin/agent/register';
const ROUTE_AGENT_PREFIX = 'admin/agent';
const RECRUIT_DELETE_ALL = 'recruits.delete.all';
const RECRUIT_IDS = 'recruits.ids';
const APPROVE_IDS = 'approve.ids';
const APPLY_IDS = 'apply.ids';
const APPLY_DELETE_ALL = 'apply.delete.all';
const APPROVE_SELECT_ALL = 'approve.select.all';
const BAR_APPROVE_SELECT_ALL = 'bar.approve.select.all';
const BAR_APPROVE_IDS = 'bar.approve.ids';
const SPECIAL_IDS = 'specials.ids';
const SPECIAL_DELETE_ALL = 'specials.delete,all';
const TOP_HTML_IDS = 'top.html.ids';
const TOP_HTML_DELETE_ALL = 'top.html.delete.all';
const LIST_HTML_IDS = 'list.html.ids';
const LIST_HTML_DELETE_ALL = 'list.html.delete.all';
const LIST_NEWS_IDS = 'list.news.ids';
const LIST_NEWS_DELETE_ALL = 'list.news.delete.all';
const CATEGORY_IDS = 'category.ids';
const CATEGORY_DELETE_ALL = 'category.delete.all';
const ADS_REGISTER_IDS = 'ads.register.ids';
const ADS_REGISTER_DELETE_ALL = 'ads.register.delete.all';
const RATE_PLAN_DELETE_ALL = 'rate_plan.delete.all';
const RATE_PLAN_IDS = 'rate_plan.ids';
const LIST_NEWS_MANAGEMENT_IDS = 'list.news_management.ids';
const LIST_NEWS_MANAGEMENT_DELETE_ALL = 'list.news_management.delete.all';
const BLACKLIST_IDS = 'blacklist.ids';
const BLACKLIST_DELETE_ALL = 'blacklist.delete_all';
const BANNED_MAIL_IDS = 'banned_mail.ids';
const BANNED_MAIL_DELETE_ALL = 'banned_mail.delete_all';
const PAGE_IDS = 'page.ids';
$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
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
var Commons = (function ($) {

    var modules = {};

    modules.setLocalStorageListIds = function ($key, $value) {
        localStorage.setItem($key, JSON.stringify($value));
    };

    modules.setLocalStorageDeleteAll = function ($key, $value) {
        localStorage.setItem($key, $value);
    };

    modules.getArrayValueLocalStorage = function (key) {
        var $value = [];

        if (JSON.parse(localStorage.getItem(key))) {
            $value = JSON.parse(localStorage.getItem(key));
        }

        return $value;
    };

    modules.getSingleValueLocalStorage = function (key) {
        var $value = NOT_DELETE_ALL;

        if (localStorage.getItem(key)) {
            $value = localStorage.getItem(key);
        }

        return $value;
    };

    modules.removeLocalStorage = function ($key) {
        localStorage.removeItem($key);
    };

    modules.getErrorMessage = function (error, errorItem,className) {
        if (typeof error != 'undefined') {
            if(errorItem != null) {
                $(className).text(errorItem);
                $(className).removeClass('hidden');
            } else {
                $(className).text('');
                $(className).addClass('hidden');
            }
        }
    };

    $('#add, #edit, #delete').on('hide.bs.modal', function(e) {
        $('.error').addClass('hidden');
        $('.error').text('');
        $('.invalid-feedback').text('');
        $('input').removeClass('is-invalid');
        // $('input[name=btSelectItem], input[name=btSelectAll]').prop('checked', false);
        $('input[name=id]').val('');
        $('#url_edit, #urlDelete').val('');
        $('form').trigger("reset");
    });

    return modules;

}(window.jQuery, window, document));

$.disableButtonSubmitWhenUploadingImage = function () {
    $('button.register').prop('disabled', true);
    $(".loading-icon").show();
    $("button.register .icon").hide();
};

$.enableButtonSubmitWhenUploadedImage = function () {
    $('button.register').prop('disabled', false);
    $(".loading-icon").hide();
    $("button.register .icon").show();
};
