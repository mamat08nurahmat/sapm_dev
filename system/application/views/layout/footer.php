<!-- container-fluid footer -->
<div class="container-fluid">
    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12" style="background-color: #055D67; height: 50px; line-height: 50px; font-size: 80%; color: #fff;">
                Copyright &copy; 2012 - 2016 PT BANK NEGARA INDONESIA, Tbk (Persero)
            </div>
        </div>
    </footer>
</div>
<!-- /.container-fluid footer -->

</div><!-- wrapp -->
</div><!-- end continer-fluid -->

<!-- jQuery -->
<script src="<?php echo JS.'jquery.js' ?>"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo JS.'bootstrap.min.js' ?>"></script>

<!-- Bootstrap Datatable -->
<script src="<?php echo JS.'datatables.min.js' ?>"></script>
<!-- Bootstrap Datatable -->

<!-----------------Acordion------------------>
<script type="text/javascript">
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].onclick = function(){
            this.classList.toggle("active");
            this.nextElementSibling.classList.toggle("show");
        }
    }
</script>
<!-----------------Acordion------------------>

<!-----------------DataTable------------------>
<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').DataTable();
			} );
</script>
<script type="text/javascript">
	// For demo to fit into DataTables site builder...
	$('#example')
		.removeClass( 'display' )
		.addClass('table table-striped table-bordered');
</script>
<!-----------------DataTable------------------>		
</body>
</html>
