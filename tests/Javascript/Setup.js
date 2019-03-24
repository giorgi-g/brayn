require('jsdom-global')();
window.Date = global.Date = Date;
global.expect = require('expect');