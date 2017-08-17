var casper = require('casper').create();
var url = casper.cli.get(0);

//var url = 'http://www.google.com';
 
casper.start(url, function() {
var js = this.evaluate(function() {
return document;
});
this.echo(js.all[0].outerHTML);
});
casper.run(); 