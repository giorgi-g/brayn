require('jsdom-global')();
window.Date = global.Date = Date;
// We can either include the expect package in each Test file or use it globally!
global.expect = require('expect');