                    
        <script src="assets/plugins/nprogress/nprogress.js"></script>
      <script src="assets/plugins/jquery/jquery.min.js"></script>
      <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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

   <script src="assets/plugins/simplebar/simplebar.min.js"></script>
  <script src="https://unpkg.com/hotkeys-js/dist/hotkeys.min.js"></script>
   <script src="assets/plugins/apexcharts/apexcharts.js"></script>
   <script src="assets/js/bootstrap.bundle.js"></script>
   <script src="assets/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
   <script src="assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
   <script src="assets/plugins/jvectormap/jquery-jvectormap-world-mill.js"></script>
   <script src="assets/plugins/jvectormap/jquery-jvectormap-us-aea.js"></script>           
   <script src="assets/plugins/daterangepicker/moment.min.js"></script>
   <script src="assets/plugins/daterangepicker/daterangepicker.js"></script>

   <script>
     jQuery(document).ready(function() {
       jQuery('input[name="dateRange"]').daterangepicker({
       autoUpdateInput: false,
       singleDatePicker: true,
       locale: {
         cancelLabel: 'Clear'
       }
     });
       jQuery('input[name="dateRange"]').on('apply.daterangepicker', function (ev, picker) {
         jQuery(this).val(picker.startDate.format('MM/DD/YYYY'));
       });
       jQuery('input[name="dateRange"]').on('cancel.daterangepicker', function (ev, picker) {
         jQuery(this).val('');
       });
     });
   </script>
  
   <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
   <script src="assets/plugins/toaster/toastr.min.js"></script>
   <script src="assets/js/mono.js"></script>
   <script src="assets/js/chart.js"></script>
   <script src="assets/js/map.js"></script>
   <script src="assets/js/custom.js"></script>