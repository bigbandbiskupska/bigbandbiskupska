(function ($, undefined) {
    $.nette.ext('spinner', {
        start: function () {
            $('html').addClass('waiting')
        },
        complete: function () {
            $('html').removeClass('waiting')
        }
    });

    $.nette.ext('loader', {
        init: function () {
            this.loader = this.findLoader();
            this.loaderField = this.loader.find('.progress-bar')
        },
        before: function (xhr, settings) {
            var that = this
            var interval = 500
            settings.timeout = settings.timeout || 5000

            if (!this.loader) {
                return;
            }

            var func = function () {
                var step = Math.ceil(interval * 100 / settings.timeout)
                var max = parseInt(that.loaderField.attr('aria-valuemax'))
                var value = parseInt(that.loaderField.attr('aria-valuenow'))
                var newValue = Math.min(max, value + step)

                that.loaderField.attr('aria-valuenow', newValue)
                that.loaderField.css('width', newValue + '%')
                that.loaderField.find('span').text(newValue + '%' + ' Completed')

                if (newValue < max) {
                    clearTimeout(this.timeout)
                    this.timeout = setTimeout(func, interval);
                }
            };

            this.timeout = setTimeout(func, interval)

            this.loader.show(this.speed);
        },
        complete: function () {
            this.loader.hide(this.speed);
            clearTimeout(this.timeout)
        }
    }, {
        findLoader: function () {
            var text = $('div.progress').text()
            return $('div.progress')
                .empty()
                .append($('<div>')
                    .addClass('progress-bar')
                    .attr('role', 'progressbar')
                    .attr('aria-valuemin', 0)
                    .attr('aria-valuemax', 100)
                    .attr('aria-valuenow', 0)
                    .text(text || 'Loading ...')
                    .append($('<span>')
                        .addClass('sr-only')))
                .hide()
        },
        loader: null,
        loaderField: null,
        speed: undefined,
        timeout: null
    });

})(jQuery);
