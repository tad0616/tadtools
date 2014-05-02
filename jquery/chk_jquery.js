function importJS(src, look_for, onload) {
    var s = document.createElement('script');
    s.setAttribute('type', 'text/javascript');
    s.setAttribute('src', src);
    if (onload) wait_for_script_load(look_for, onload);
    if (eval("typeof " + look_for) == 'undefined') {
        var head = document.getElementsByTagName('head')[0];
        if (head) head.appendChild(s);
        else document.body.appendChild(s);
    }
}

function wait_for_script_load(look_for, callback) {
  var interval = setInterval(function() {
        if (eval("typeof " + look_for) != 'undefined') {
            clearInterval(interval);
            callback();
        }
    }, 50);
}
