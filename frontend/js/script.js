var app = $.spapp({
    defaultView: "#mainpage",
    templateDir: "../views/"
});

// Define routes separately
app.route({
    view: "login",
    load: "login.html",
    onCreate: function () {
        if (typeof UserService !== 'undefined' && typeof UserService.init === 'function') {
            UserService.init();
        } else {
            console.error("UserService is not available.");
        }
    }
});



app.run();
