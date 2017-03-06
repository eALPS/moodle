YUI({}).use("node","dom-core", function(Y)
{
    Y.on
        (
            "load",
            function(e)
            {
                var patt = /add=mediasite/i;
                if(patt.test(document.location.search)) {
                    var url = Y.one('#id_searchurl');
                    patt = /MSIE\s+\d+/m;
                    if(patt.test(window.clientInformation.appVersion)) {
                        window.open(url.get('value'),
                            '',
                            'menubar=1,location=1,directories=1,toolbar=1,scrollbars,resizable,width=800,height=600');

                    } else {
                        window.open(url.get('value'),
                            'Mediasite Search',
                            'menubar=1,location=1,directories=1,toolbar=1,scrollbars,resizable,width=800,height=600');
                    }
                }
            },
            Y.config.win
        );
});
