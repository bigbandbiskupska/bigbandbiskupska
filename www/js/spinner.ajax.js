(function ($, undefined) {

    $.nette.ext('spinner', {
        init: function () {
            this.spinner = this.createSpinner();
            this.spinner.appendTo('body');
            this.recordOnMouseMove = this.recordOnMouseMove.bind(this)
        },
        before: function (xhr, settings) {
            if (settings.nette && settings.nette.el) {
                var positions = settings.nette.el.get(0).getBoundingClientRect()
                this.spinner.css({
                    top: positions.top,
                    left: positions.left,
                })
            }

            if (!this.spinner) {
                return;
            }

            window.addEventListener('mousemove', this.recordOnMouseMove, false);

            this.spinner.show(this.speed);
        },
        complete: function () {
            this.spinner.hide(this.speed);
            window.removeEventListener('mousemove', this.recordOnMouseMove, false);
        }
    }, {
        recordOnMouseMove: function (e) {
            this.spinner.css({top: e.pageY, left: e.pageX});
        },
        createSpinner: function () {
            return $('<div>', {
                id: 'ajax-spinner',
                css: {
                    display: 'none',
                    width: '30px',
                    height: '30px',
                    zIndex: 10000000,
                }
            });
        },
        spinner: null,
        speed: undefined,
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
