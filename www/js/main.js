
if (!String.prototype.format) {
  String.prototype.format = function() {
	var args = arguments;
	return this.replace(/{(\d+)}/g, function(match, number) {
	  return typeof args[number] != 'undefined'
		? args[number]
		: match
	  ;
	});
  };
}

$(window).load(function() {
	// smooth scroll to the anchor id
	if(window.location.hash && $(window.location.hash).length) {
		$('html, body').animate({
				scrollTop: $(window.location.hash).offset().top + 'px'
			}, 1000);
	}
})


$(function() {
	if(jQuery.nette && window.history && window.history.pushState) {
		jQuery.nette.ext('paginator', {
			success: function (x, y, z, settings) {
				if(settings &&
				   settings.url &&
				   settings.url.startsWith(window.location.protocol + '//' + window.location.hostname) && // local
				   settings.nette &&
				   settings.nette.e &&
				   settings.nette.el &&
				   settings.nette.e.type === 'click' && // click event
				   settings.nette.el.is('a.ajax')) { // preferable on an anchor
						window.history.pushState({}, "", settings.url)
				}
			}
		});
	}

	$("#mini-nav-menu ul li a[href^='#']").filter(':not(.lang)').click(function(e) {
		if($(".navbar-toggle:visible").length)
			$("#mini-nav-menu").collapse("toggle");
	});

	// #target handling

	$("a[href^='#'], map area").filter(':not(.lang)').click(function(e) {
		if($(this.hash).length === 0) // it does not exist
			return true

		e.preventDefault()

		var removeHash = function() {
			if(history.replaceState) {
				history.replaceState(null, null, window.location.pathname + window.location.search)
			} else {
				var offset = $(window).scrollTop()
				window.location.hash = ''
				$(window).scrollTop(offset)
			}
		};

		var changeHash = function(hash) {
			if(history.pushState) {
				history.pushState(null, null, hash)
			} else {
				window.location.hash = hash
			}
		}

		var hash = this.hash
		var $that = $(this)

		$('html, body').stop().animate({
			scrollTop: $(this.hash).offset().top + 'px'
		}, 1000, function(){
			if(['#top', '#nahoru'].indexOf($that.attr('href')) >= 0) {
				removeHash();
			} else {
				changeHash(hash);
			}
		})
	});


	// to the top button

	$("#top-button").each(function() {
		var $that = $(this)
		var scroll = function($el, y) {
			if (y === 0) { // at the top
				$el
				.filter(":visible")
				.animate({
					right: -$el.width() - 10
				}, 500, function() {
					$el.hide()
				})
			} else if(y > 0) { // scrolled a bit
				$el
				.not(":visible")
				.show()
				.animate({
					right: '3%'
				})
			}
		}

		$that.click(function(e) {
			if ($(e.target).is($that)) {
				$that.find("a").click()
			}
		})

		$(window).load(function(e) {
			scroll($that, $(window).scrollTop())
		});

		var timeout = null;
		$(window).scroll(function(e) {
			if(!$that.is(":visible") || $(window).scrollTop() === 0) {
				if(timeout) {
					clearTimeout(timeout);
				}
				timeout = setTimeout(scroll, 200, $that, $(window).scrollTop())
			}
		});
	})

	/*
		$('#mini-nav-menu .navbar-nav li a, area').click(function(e) {
			if(!$(this).attr('href').startsWith('#')) return true;
			e.preventDefault();
			$($(this).attr('href'))[0].scrollIntoView();
			scrollBy(0, -offset);
		});
	*/
	var timeout = null;

	$("#filter").keyup(function(){
		var $that = $(this);

		if(timeout) {
			clearTimeout(timeout);
			timeout = null;
		}

		timeout = setTimeout(function() {
			$("ul.song-list li.song-empty").remove()

			var removeHighlight = function($el) {
				$el.text($el.data("text") || $el.text())
			};

			var addHightlight = function($el, start, end) {
				var text = $el.text()
				$el.data("text", $el.text()); // save old
				$el.empty()
				$("<span>")
					.text(text.substring(0, start))
					.appendTo($el)
				$("<span>")
					.addClass('list-group-item-success')
					.text(text.substring(start, start + end))
					.appendTo($el);
				$("<span>")
					.text(text.substring(start + end, text.length))
					.appendTo($el)
			}

			$("ul.song-list li").each(function(){
				var $el = $(this)
				var name = $el.find(".song-name").first().text().toLowerCase();
				var author = $el.find(".song-interpreter").first().text().toLowerCase();
				var val = $that.val().toLowerCase();
				var n = name.indexOf(val)
				var a = author.indexOf(val)

				removeHighlight($el.find(".song-name").first())
				removeHighlight($el.find(".song-interpreter").first())

				$el.show();
				if(n < 0 && a < 0) {
					$el.hide();
				} else if (n < 0) {
					addHightlight($el.find(".song-interpreter").first(), a, val.length)
				} else if (a < 0) {
					addHightlight($el.find(".song-name").first(), n, val.length)
				} else {
					addHightlight($el.find(".song-interpreter").first(), a, val.length)
					addHightlight($el.find(".song-name").first(), n, val.length)
				}
			});

			$("ul.song-list").each(function(){
				var length = $(this).find("li:visible").length
				if(length <= 0) {
					$("<li>").addClass("list-group-item")
						   .addClass("col-xs-12")
						   .addClass("song-empty")
						   .html("Bohužel tomuto vyhledávání nevyhovuje žádná položka.")
						   .appendTo($(this))
				}
				$(".song-count").text(length);
			});
		}, 300);
	});

	var loadFlickerImages = function() {
		$images = $(".google-image").filter(function() {
			return !$(this).data('google-image-loaded');
		});

		if($images.length === 0) {
			return;
		}

		var baseUrl = "https://api.flickr.com/services/rest/";
		var authKey = "0341f1f52bbe6222c1388e750d548a62"
		var albums = {};

		$images.each(function() {
			var photoId = $(this).data('photoId') || null
			var albumId = $(this).data('albumId') || null
			
			if (!photoId || !albumId) return;

			albums[albumId] = {}
		});

		var fill = function() {
			var photoId = $(this).data('photoId') || null
			var albumId = $(this).data('albumId') || null
			var $that = $(this)

			if(!albumId || !photoId || !albums[albumId] || !albums[albumId][photoId] ) {
				console.debug('Could not find a image data for album ' + albumId + ' and photo ' + photoId);
				return;
			}

			var e = albums[albumId][photoId];
			var thumbnail = e.url_m;
			var image = e.url_o;
			var $img = $('<img>')
					.prop('src', thumbnail)
					.prop('alt', e.title)
					.addClass('img img-rounded')
					.addClass('img-resp')
					.addClass('img-responsive')
			$('<a>')
					.append($img)
					.prop('href', image)
					.prop('title', e.title)
					.attr('data-gallery', '')
					.appendTo($that)

			$that.data('google-image-loaded', true)
		};

		var promises = [];
		for(var key in albums) {
			var params = {
				method: 'flickr.photosets.getPhotos',
				user_id: '153036765@N08',
				api_key: authKey,
				photoset_id: key,
				extras: 'url_o,url_m',
				per_page: 500,
				format: 'json',
				media: 'photos',
				nojsoncallback: '1',
			};

			var url = baseUrl + '?' + Object.keys(params).map(key => key + '=' + params[key]).join('&');

			promises.push(
				$.nette.ajax({
					url: url,
					timeout: 10000,
					dataType: 'json',
					off: ['spinner', 'unique']
				}).done(function(result) {
					if (!result.photoset || !result.photoset.photo || !result.photoset.photo.length) {
						return;
					}
					for ( var i = 0; i < result.photoset.photo.length; i ++ ) {
						var e = result.photoset.photo[i];
						albums[key][e.id] = e;
					}
				}).fail(function(e){
					console.debug('Failed loading album ' + key);
				})
			);
		}

		Promise.all(promises).then(function() {
			$images.each(fill);
		});
	};

	jQuery.nette.ext({
		load: loadFlickerImages
	});

	// finally fire nette init
	$.nette.init();
});