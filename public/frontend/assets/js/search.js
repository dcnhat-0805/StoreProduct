const COLOR = 'color';
const DISCOUNT = 'discount';
const RATING = 'rating';
const PRICE = 'price';

const ARRAY_FILTER = ['color', 'discount', 'size', 'materials'];

$(document).ready(function () {

    function getAllUrlParams(url) {

        // get query string from url (optional) or window
        let queryString = url ? url.split('?')[1] : window.location.search.slice(1);

        // we'll store the parameters here
        let obj = {};

        // if query string exists
        if (queryString) {

            // stuff after # is not part of query string, so get rid of it
            queryString = queryString.split('#')[0];

            // split our query string into its component parts
            let arr = queryString.split('&');

            for (let i=0; i<arr.length; i++) {
                // separate the keys and the values
                let a = arr[i].split('=');

                // in case params look like: list[]=thing1&list[]=thing2
                let paramNum = undefined;
                let paramName = a[0].replace(/\[\d*\]/, function(v) {
                    paramNum = v.slice(1,-1);
                    return '';
                });

                // set parameter value (use 'true' if empty)
                let paramValue = typeof(a[1])==='undefined' ? true : a[1];

                // (optional) keep case consistent
                paramName = paramName.toLowerCase();
                paramValue = paramValue.toLowerCase();
                paramValue = paramValue.replace(/%2c/g, ',');

                // if parameter name already exists
                if (obj[paramName]) {
                    // convert value to array (if still string)
                    if (typeof obj[paramName] === 'string') {
                        obj[paramName] = [obj[paramName]];
                    }
                    // if no array index number specified...
                    if (typeof paramNum === 'undefined') {
                        // put the value on the end of the array
                        obj[paramName].push(paramValue);
                    }
                    // if array index number specified...
                    else {
                        // put the value at that index number
                        obj[paramName][paramNum] = paramValue;
                    }
                }
                // if param name doesn't exist yet, set it
                else {
                    obj[paramName] = paramValue;
                }
            }
        }

        return obj;
    }

    function urlParam(name) {
        let results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results == null){
            return null;
        }
        else{
            return decodeURIComponent(results[1]);
        }
    }

    function removeURLParameter(url, parameter) {
        //prefer to use l.search if you have a location/link object
        let urlParts = url.split('?');

        if (urlParts.length >= 2) {

            let prefix = encodeURIComponent(parameter)+'=';
            let pars = urlParts[1].split(/[&;]/g);

            //reverse iteration as may be destructive
            for (let i = pars.length; i-- > 0;) {
                //idiom for string.startsWith
                if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                    pars.splice(i, 1);
                }
            }

            url = urlParts[0]+'?'+pars.join('&');


            let newParts = url.split('?');

            if (!newParts[1].length) return url.replace('?', '');

            return url;
        } else {
            return url;
        }
    }

    function convertArrayStringToArrayFloat(array) {
        let newArray = array.split(',').map(function(item) {
            return parseFloat(item, 10);
        });

        return newArray;
    }

    function setNewHref(element, param, value) {
        let text = element.data('href');
        if (text) {
            let href = new URL(text);
            href.searchParams.set(param, value);
            element.attr('data-href', href);

            return href;
        }
    }

    ARRAY_FILTER.forEach(function (filter) {
        checkBoxFilterSearch(filter);
    });

    function checkBoxFilterSearch(filter) {
        $('input.jsCheckBox[name="'+ filter +'"]').each(function (i, e) {
            $(e).on('ifChanged', function () {
                let param = $(this).attr('name');
                let value = $(this).val();
                let url = setNewHref($('input.jsCheckBox[name="'+ filter +'"]'), param, value);

                window.location.href = url;

                // $('input.jsCheckBox:not(:checked)[name=brand]').parent().parent().hide();
            });
            $(e).on('ifUnchecked', function () {
                let param = $(this).attr('name');
                let value = '';
                let url = setNewHref($('input.jsCheckBox[name="'+ filter +'"]'), param, value);
                url = removeURLParameter(url.href, param);
                url = new URL(url);

                window.location.href = url;

                // $('input.jsCheckBox:not(:checked)[name=brand]').parent().parent().hide();
            });
        });
    }

    ARRAY_FILTER.forEach(function (filter) {
        setParamsChecked(filter);
    });

    function setParamsChecked(filter)
    {
        let filterSearch = urlParam(filter);
        if(filterSearch) {
            filterSearch = filterSearch.split(/,|%2C/);
            if (filterSearch != null && filterSearch.length > 0) {
                $('input.jsCheckBox[name="'+ filter +'"]').each(function () {
                    let attr = $(this).val();

                    if (filterSearch.includes(attr)) {
                        $(this).prop('checked', true);
                        $(this).parent().addClass("checked");
                    } else {
                        $(this).prop('checked', false);
                        $(this).parent().removeClass("checked");
                    }
                });
            }
        }
    }

    $('.filter__rating').each(function (index, value) {
        $(value).on('click', function (e) {
            e.preventDefault();
            $(this).toggleClass('active');
            let param = $(this).data('name');
            let value = $(this).data('rating');
            let url = setNewHref($(this), param, value);
            if (!$(this).hasClass('active')) {
                url = removeURLParameter(url.href, param);
                url = new URL(url);
            } else {
                url = setNewHref($(this), param, value);
            }

            window.location.href = url;
        });
    });

    let filterRating = urlParam(RATING);
    if(filterRating) {
        if (filterRating != null && filterRating > 0) {
            $('.filter__rating[data-rating="'+ parseFloat(filterRating) +'"]').addClass('active');
        }
    }

    let filterPrice = urlParam(PRICE);

    if (filterPrice) {
        filterPrice = convertArrayStringToArrayFloat(urlParam(PRICE));
        if (!isNaN(filterPrice[0]) && filterPrice[0]) {
            $('.filter__price__min').val(filterPrice[0]);
        }

        if (!isNaN(filterPrice[1]) && filterPrice[1]) {
            $('.filter__price__max').val(filterPrice[1]);
        }
    }

    $('.btn-search__by__price').on('click', function () {
        let price = [];
        let param = 'price';
        let min = $('.filter__price__min').val();
        let max = $('.filter__price__max').val();

        price.push([min, max]);
        $('.filter__price-value').val(price);

        let url = setNewHref($(this), param, price);
        if (!min && !max) {
            url = removeURLParameter(url.href, param);
            url = new URL(url);
        } else {
            url = setNewHref($(this), param, price);
        }

        window.location.href = url;
    });

    function setUrlParam(url, param, value){
        let hash       = {};
        let parser     = document.createElement('a');

        parser.href    = url;

        let parameters = parser.search.split(/\?|&/);

        for(let i=0; i < parameters.length; i++) {
            if(!parameters[i])
                continue;

            let ary      = parameters[i].split('=');
            hash[ary[0]] = ary[1];
        }

        hash[param] = value;

        let list = [];
        Object.keys(hash).forEach(function (key) {
            list.push(key + '=' + hash[key]);
        });

        parser.search = '?' + list.join('&');

        return parser.href;
    }

});
