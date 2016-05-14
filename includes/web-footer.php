<!-- jQuery 2.1.4 -->
<script src="/initiative-tracker/ver0.3/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
 $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.5 -->
<script src="/initiative-tracker/ver0.3/bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="/initiative-tracker/ver0.3/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="/initiative-tracker/ver0.3/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/initiative-tracker/ver0.3/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/initiative-tracker/ver0.3/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="/initiative-tracker/ver0.3/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="/initiative-tracker/ver0.3/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="/initiative-tracker/ver0.3/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/initiative-tracker/ver0.3/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/initiative-tracker/ver0.3/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/initiative-tracker/ver0.3/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="/initiative-tracker/ver0.3/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/initiative-tracker/ver0.3/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/initiative-tracker/ver0.3/dist/js/demo.js"></script>

<!-- UPDATE DIRECTORIES -->
<script type="text/javascript">
  $(document).ready(function () {
    $(".department").click(function () {
      var link = $(this).attr("href");
      var req =  new XMLHttpRequest();
      alert(req);
      req.onerror = function(){
        alert("error");
      }
      req.open("get", $(this).attr("href"), true);
      req.send();
      // $.ajax({
      //   type: 'HEAD',
      //   url: $(this).attr("href"),
      //   async: false,
      //   success: function() {
      //     // do nothing
      //   },
      //   error: function() {
      //     alert("/initiative-tracker/ver0.3/includes/update.php?url=" + link);
      //     $.ajax({
      //       type: 'GET',
      //       url: "/initiative-tracker/ver0.3/includes/update.php?url=" + link,
      //       async: false,
      //       success: function(data) {
      //         // Run the code here that needs
      //         //    to access the data returned
      //         alert(data);
      //       }
      //     });
      //     alert("WHATTT???");
      //   }
      // });
      return false;
    })
  })
</script>