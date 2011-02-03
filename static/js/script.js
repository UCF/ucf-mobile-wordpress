function get_month_from_rss(str){
	var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	var index  = Number(str.substr(5, 2));
	return months[index - 1];
}

function get_day_from_rss(str){
	return str.substr(8, 2);
}

var __init__ = (function($){
	$('.slideshow').imageRotate();
	$('.select-links').selectLink();
	
	if ($('.events').length != 0){
		$('.events').each(function(){
			var _this    = $(this);
			var calendar = _this.attr('data-calendar-id');
			var url      = _this.attr('data-url');
			if (!calendar){calendar = 1;}
			if (!url){url = 'http://events.ucf.edu';}
			
			$.getUCFEvents({
					'calendar_id' : calendar,
					'url'         : PROVOST_MISC_URL+'/events.php',
					'limit'       : 4}, function(data, status, request){
				if (data == null){return;}
				
				for (var i = 0; i < data.length; i++){
					var e     = data[i];
					var event = $('<li />', {'class' : 'event'});
					var date  = $('<div />', {'class' : 'date'});
					var month = $('<span />', {'class' : 'month'});
					var day   = $('<span />', {'class' : 'day'});
					var title = $('<a>', {'class' : 'title', 'href' : url + '?eventdatetime_id='+e.id});
					var end   = $('<div>', {'class' : 'end'});
					
					title.text(e.title);
					day.text(get_day_from_rss(e.starts));
					month.text(get_month_from_rss(e.starts));
					
					date.append(month);
					date.append(day);
					event.append(date);
					event.append(title);
					event.append(end);
					_this.append(event);
				}
			});
		});
	}
});


(function($){
	$.fn.imageRotate = (function(arguments){
		var defaults = {
			'fade_length'  : 2000,
			'image_length' : 6000
		};
		var options      = $.extend({}, defaults, arguments);
		var container    = $(this);
		
		var active = $(this).children('img.active');
		if (active.length < 1){
			active = $(this).children('img:last');
			active.addClass('active');
		}
		
		var next = active.next();
		if (next.length < 1){
			next = $(this).children('img:first');
		}
		
		active.addClass('last-active');
		next.css({'opacity' : 0.0});
		next.addClass('active');
		next.animate({'opacity': 1.0}, options.fade_length, function(){
			active.removeClass('active last-active');
		});
		
		setTimeout(function(){container.imageRotate(options);}, options.image_length);
	});
	
	$.fn.selectLink = (function(arguments){
		var _this = $(this);
		_this.change(function(){
			var selected = _this.children('option:selected');
			var url      = selected.attr('value');
			if (url != 'null'){
				window.location = url;
			}
		});
	});
	
	__init__($);
})(jQuery);
