var appIndex = function () {
    "use strict";

    return {
        /**
         * Init
         */
        init: function () {
            window.fitText( document.getElementsByClassName("fittext"), 0.53);
            this.post;
        },

        post: function () {
            const siteKey = '6Ld8rPIaAAAAANOxNNEV8oGIiz2p13NoLsKwfJBd';

            grecaptcha.ready(function() {
                grecaptcha.execute(siteKey, {
                    action: 'contact_form'
                }).then(function(token) {
                    //submit the form
                    return http.post(url, {email, captcha: token});
                });
            });
        }
    };
}();