        <!-- footer content -->
        <footer>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="/bacara/admin/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="/bacara/admin/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- NProgress -->
    <script src="/bacara/admin/vendors/nprogress/nprogress.js"></script>
    <!-- Datatables -->
    <script src="/bacara/admin/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/bacara/admin/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- Parsley -->
    <script src="/bacara/admin/vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="/bacara/admin/build/js/main.js"></script>

    <script type="text/javascript">
      function updateCredit(userId) {
        var data = {
            userId: userId,
            credit: $("#credit_"+userId).val()
        }
        $.post("/bacara/admin/portal.php?updateCredit",
            data
        ,
        function(data){
            if(data==1){
                alert("บันทึก credit เรียบร้อย");
            } else {
                alert("บันทึก credit ล้มเหลว");
            }
        });
      }

      function submit() {
        $.post("/bacara/admin/portal.php?changePassword",
        $("#form1").serialize(),
        function(data){
            if(data==1){
                alert("บันทึก Password เรียบร้อย");
                window.location = "";
            } else {
                alert(data);
            }
        });

        return false;
      }
    </script>
  </body>
</html>