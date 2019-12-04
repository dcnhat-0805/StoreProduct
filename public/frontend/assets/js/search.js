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

    function urlParam(name){
        let results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results==null) {
            return null;
        } else {
            return results[1] || 0;
        }
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

    $('input.jsCheckBox[name=brand]').each(function (i, e) {
        $(e).on('ifChanged', function () {
            let param = $(this).attr('name');
            let value = $(this).val();
            setNewHref($("input.jsCheckBox:checked[name=brand]"), param, value);
            let url = setNewHref($("input.jsCheckBox:checked[name=brand]"), param, value);
            window.location.href = url;
            $('input.jsCheckBox:not(:checked)[name=brand]').parent().parent().hide();
        })
    });

    setParamsChecked();
    function setParamsChecked()
    {
        let brandSearch = urlParam('brand');
        if(brandSearch) {
            brandSearch = brandSearch.split(/,|%2C/);
            if (brandSearch != null && brandSearch.length > 0) {
                $('input.jsCheckBox[name=brand]').each(function () {
                    let brand = $(this).val();

                    if (brandSearch.indexOf(brand) != -1) {
                        $(this).parent().addClass("checked");
                    }
                });
            }
        }
    }

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
