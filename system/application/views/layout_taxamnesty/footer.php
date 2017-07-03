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
<script src="<?php echo NEWJS.'jquery-1.4.2.min.js' ?>"></script>

<script src="<?php echo NEWJS.'html5shiv.js' ?>"></script>
<script src="<?php echo NEWJS.'respond.min.js' ?>"></script>

<!-- Bootstrap Datatable -->
<script src="<?php echo NEWJS.'datatables.min.js' ?>"></script>
<!-- Bootstrap Datatable -->

<!-- datetimepicker -->
	<script src="<?php echo NEWJS.'moment.js' ?>"></script>
	<script src="<?php echo NEWJS.'bootstrap-datetimepicker.min.js' ?>"></script>
	<!-- end datetimepicker -->

<!-- Bootstrap Datepicker -->
<script src="<?php echo NEWJS.'bootstrap-datepicker.js' ?>"></script>
<!-- Bootstrap Datepicker -->

<!-- Bootstrap Datepicker -->
<script src="<?php echo NEWJS.'jquery.maskMoney.js' ?>"></script>
<!-- Bootstrap Datepicker -->

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
	// jquery datatables
	$('#example')
		.removeClass( 'display' )
		.addClass('table table-striped table-bordered');

	// datepicker
	$(function(){

		// $("#tanggal1").datepicker({
			// format: 'd-m-yyyy'
		// });
		$('#tanggal1').datetimepicker({
            format: 'DD-MMM-YYYY',

			// //locale: 'id'
        });

		///////////////////LIMIT TANGGAL 1 BULAN FILTER//////////////////

		$('#tanggal2').datetimepicker({
            format: 'DD-MMM-YYYY',

			// //locale: 'id'
        });

		$('#tanggal3').datetimepicker({
            format: 'DD-MMM-YYYY',
			// //locale: 'id'
        });
		$('#tanggal3').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });

		$("#tanggal2").on("dp.change", function (e) {
            $('#tanggal3').data("DateTimePicker").minDate(e.date);
			$('#tanggal3').data("DateTimePicker").maxDate(e.date.add(1, 'M').toDate());
        });

		$("#tanggal3").on("dp.change", function (e) {
            $('#tanggal2').data("DateTimePicker").maxDate(e.date);
        });

		///////////////////LIMIT TANGGAL 1 BULAN FILTER//////////////////


	})
</script>
<!-----------------DataTable------------------>


</body>
</html>
