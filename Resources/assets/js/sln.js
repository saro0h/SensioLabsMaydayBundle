(function(w, d, s) {
    function go() {
        var js, fjs = d.getElementsByTagName(s)[0], load = function(url, id) {
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.src = url; js.id = id;
            fjs.parentNode.insertBefore(js, fjs);
        };
        load('https://connect.sensiolabs.com/sln.js?customize_url='+sln_customiser_path, 'sln_bar');
    }
    if (w.addEventListener) { w.addEventListener("load", go, false); }
    else if (w.attachEvent) { w.attachEvent("onload", go); }
} (window, document, 'script'));
