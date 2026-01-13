// To prevent saving web site directly using "ctrl-s"
$(document).bind('keydown keypress', 'ctrl+s', function () {
        $('#save').click();
        return false;
    });;