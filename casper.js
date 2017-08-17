var casper = require('casper').create();

var url = casper.cli.get(0);
var p   = casper.cli.get(1);
casper.checkLink = function checkLink() {
    this.echo('Setting up check steps...');
    this.open(url).then(function() {
        if (this.exists('#nextPage')) {
            this.echo('link was found, clicking');
			for(var i = 0; i < p; i++){
				this.thenClick('#nextPage');
			}
			casper.then(function() {
                // add stuff to be done
			var selector;
			casper.then(function() {
			selector = "span[class=discAvs]";
			});

			casper.then(function() {
			this.waitForSelector(selector);
			});
			
			casper.then(function() {
				this.wait(1000);
				var js = this.evaluate(function() {
				return document;
				});
				this.echo(js.all[0].outerHTML); 
                // ... then exit
                this.echo('Done.').exit();
			});	
            });
        } else {
            this.warn('Link not found, scheduling another attempt');
            this.wait(interval);
        }
    });
    this.run(this.checkLink);
};

casper.start().checkLink();
   
casper.run();