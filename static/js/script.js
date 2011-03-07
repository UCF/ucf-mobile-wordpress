var __init__ = (function($){});

var _sf_async_config    = {};
_sf_async_config.uid    = CB_ACCOUNT;
_sf_async_config.domain = CB_DOMAIN;
(function(){
	function loadChartbeat() {
		window._sf_endpt=(new Date()).getTime();
		var e = document.createElement('script');
		e.setAttribute('language', 'javascript');
		e.setAttribute('type', 'text/javascript');
		e.setAttribute('src', (
			("https:" == document.location.protocol) ? 
			"https://a248.e.akamai.net/chartbeat.download.akamai.com/102508/" :
			"http://static.chartbeat.com/") +
		"js/chartbeat.js");
		document.body.appendChild(e);
	}
	var oldonload = window.onload;
	window.onload = (typeof window.onload != 'function') ? loadChartbeat : function() {
		oldonload(); loadChartbeat();
	};
})();