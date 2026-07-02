<script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.hoverIntent.min.js"></script>
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/superfish.min.js"></script>    
    <script src="assets/js/bootstrap-input-spinner.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/jquery.plugin.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/jquery.countdown.min.js"></script>
    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/demos/demo-7.js"></script>

    <script>
    function showSuccessErrorMsg(status, msg) {

        $('.alert').hide();

        let targetId = '';

        if (status == 'error') {
            targetId = '#res_error_msg';
            $('#res_error_msg .error-msg').html(msg);

        } else if (status == 'success') {
            targetId = '#res_success_msg';
            $('#res_success_msg .success-msg').html(msg);

        } else {
            targetId = '#res_warning_msg';
            $('#res_warning_msg .warning-msg').html(msg);
        }

        let $el = $(targetId);

        // Purani animation classes remove
        $el.removeClass('animate__fadeOutUp animate__fadeInDown');

        // Show Alert
        $el.show().addClass('animate__animated animate__fadeInDown');

        // 3 sec baad hide
        setTimeout(() => {

            $el.removeClass('animate__fadeInDown')
               .addClass('animate__fadeOutUp');

            // Animation complete hone ke baad hide
            setTimeout(() => {
                $el.hide();
                $el.removeClass('animate__fadeOutUp');
            }, 1000);

        }, 3000);
    }

    $(document).ready(function() {

        let RES_MSG = "<?= $MSG ?>";

        if (RES_MSG != '') {

            let msgs = RES_MSG.split('--');

            let status = msgs[0];
            let msgText = msgs[1];

            showSuccessErrorMsg(status, msgText);
        }
    });
</script>

    