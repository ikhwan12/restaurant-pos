function connectAndPrint(pos, struk) {
    // our promise chain
    connect().then(function() {
        return print(pos, struk);
    }).then(function() {
        success();              // exceptions get thrown all the way up the stack
    }).catch(fail);             // so one catch is often enough for all promises
    
    // NOTE:  If a function returns a promise, you don't need to wrap it in a fuction call.
    //        The following is perfectly valid:
    //
    //        connect().then(print).then(success).catch(fail);
    //
    // Important, in this case success is NOT a promise, so it should stay wrapped in a function() to avoid confusion
}
function connectAndPrint2(pos, struk) {
    // our promise chain
    connect().then(function() {
        return print2(pos, struk);
    }).then(function() {
        success();              // exceptions get thrown all the way up the stack
    }).catch(fail);             // so one catch is often enough for all promises
    
    // NOTE:  If a function returns a promise, you don't need to wrap it in a fuction call.
    //        The following is perfectly valid:
    //
    //        connect().then(print).then(success).catch(fail);
    //
    // Important, in this case success is NOT a promise, so it should stay wrapped in a function() to avoid confusion
}

// connection wrapper
//  - allows active and inactive connections to resolve regardless
//  - try to connect once before firing the mimetype launcher
//  - if connection fails, catch the reject, fire the mimetype launcher
//  - after mimetype launcher is fired, try to connect 3 more times
function connect() {
    return new RSVP.Promise(function(resolve, reject) {
        if (qz.websocket.isActive()) {	// if already active, resolve immediately
            resolve();
        } else {
            // try to connect once before firing the mimetype launcher
            qz.websocket.connect().then(resolve, function reject() {
                // if a connect was not succesful, launch the mimetime, try 3 more times
                window.location.assign("qz:launch");
                qz.websocket.connect({ retries: 2, delay: 1 }).then(resolve, reject);
            });
        }
    });
}

// print logic
function print(pos, struk) {
    var source = base_url+'assets/struk/'+struk+'.txt';
    var printer = pos;
    var options =  { language: "escp", dotDensity: 'double' };
    var data = [{ type: 'raw', format: 'file', data:source }];
    var config = qz.configs.create(printer, options);
    // return the promise so we can chain more .then().then().catch(), etc.
    return qz.print(config, data);
}

function print2(pos, struk) {
    var source = base_url+'assets/dapur/'+struk+'.txt';
    var printer = pos;
    var options =  { language: "escp", dotDensity: 'double' };
    var data = [{ type: 'raw', format: 'image', data: base_url+'assets/images/image_sample_bw.png'},
                { type: 'raw', format: 'file', data:source }];
    var config = qz.configs.create(printer, options); 
                    // **for legacy drawer cable CD-005A.  Research before using.

    // return the promise so we can chain more .then().then().catch(), etc.
    return qz.print(config, data);
}

// notify successful print
function success() { 
    console.log("Success");
}

// exception catch-all
function fail(e) {
    console.error("Error: " + e);
}
