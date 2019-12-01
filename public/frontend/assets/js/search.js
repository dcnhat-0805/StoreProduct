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
        console.log(text, new URL(text));
        if (text) {
            let href = new URL(text);
            href.searchParams.set(param, value);
            element.data('href', 1);
        }
    }

    $('input.jsCheckBox').each(function (i, e) {
        $(e).on('ifChanged', function () {
            console.log($(this).data('href'), getAllUrlParams($(this).data('href')));
            // console.log(setNewHref($(this), 'local, 1'));
            // window.href.location = '/'
        })
    })

});
