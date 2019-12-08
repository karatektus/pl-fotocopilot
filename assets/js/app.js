var plApp = function () {
    "use strict";

    return {
        /**
         * Start loading
         */
        loadingStart: function () {
            this.debug('plApp', 'loadingStart()');
            KTApp.blockPage();
        },
        /**
         * Stop loading
         */
        loadingStop: function () {
            this.debug('plApp', 'loadingStop()');
            KTApp.unblockPage();
        },

        displayAjaxError: function () {
            plApp.loadingStop();
            plDialog.alertMessage(plTranslate.ajax_error, {
                title: plTranslate.error
            });
        },
        /**
         * Init
         * @returns {*|void}
         */
        init: function () {
            this.debug('plApp', 'init()');

            this.initEvents();
            this.initMessages();
            this.initVendors();

            let $body = $('body');
            /* Pages */
            if (true === $body.hasClass('app--page-ac2f7024')) {
                return appIndex.init();
            }
            if (true === $body.hasClass('app--page-3d5f697b')) {
            }
        },
        /**
         * Init AJAX
         */
        initAjax: function ($body) {
            this.debug('plApp', 'initAjax()');
        },

        /**
         * Init Events
         */
        initEvents: function () {
            var $body = $('body');

            $body
                .on('click', function (event) {
                    var $the = $(event.target);

                    if ('A' === $the.prop('tagName') || 0 < $the.parents('a').length) {
                        /* Link clicked */
                        var $link = $the.closest('a');

                        if (true === $link.hasClass('pl--dialog')) {
                            return plDialog.click($link);
                        }

                        if (true === $link.hasClass('approvable')) {
                            return plDialog.confirm($link, plDialog.getOptionsByLink($link));
                        }

                        /* link empty? dont delete saved tab */
                        if ($link.attr('href') === '#') {
                            return;
                        }
                        /* still here? delete saved tab */
                        let activeTab = localStorage.getItem('activeTab');
                        if (activeTab && !$($link).closest(activeTab).length) {
                            localStorage.removeItem('activeTab');
                        }

                    }
                })
                .on('change', function (event) {
                    var $the = $(event.target);

                    if (true === $the.hasClass('app--config')) {
                        return plConfig.update($the);
                    }

                    if (true === $the.hasClass('pl--pagination-limit')) {
                        return plTable.updateLimit($the);
                    }
                });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });

            let activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
            }
        },
        /**
         * Init Vendors
         */
        initVendors: function () {

        },
        /**
         * Init Messages
         */
        initMessages: function () {
            if (typeof plMessages !== "object" || 0 === plMessages.length) {
                return false;
            }

            for (var messageIndex = 0; messageIndex < plMessages.length; messageIndex++) {
                if ('success' === plMessages[messageIndex].type) {
                    toastr.success(plMessages[messageIndex].message);
                } else if ('error' === plMessages[messageIndex].type) {
                    toastr.error(plMessages[messageIndex].message);
                } else {
                    toastr.info(plMessages[messageIndex].message)
                }
            }
        },
        /**
         * Debug
         */
        debug: function (type) {
            if (true === plAppConfig.debug) {
                for (var i = 1; i < arguments.length; i++) {
                    console.log('%c' + type + ' %c' + arguments[i], "background:#222;color:#eba4d2;padding:2px;", "background:#222;color:#fff;padding:2px;");
                }
            }
        }
    };
}();

plApp.init();