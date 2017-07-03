<?php
	$this->load->view('layout_phr_nasabah/header.php'); 	
?>

	<!-- jQuery -->
	<script src="<?php echo NEWJS.'jquery.js' ?>"></script>

<!-- Konten Isi -->
<div class="container">

    <!-- Marketing Icons Section -->
    <div class="row">
        <div class="col-lg-12">

            <!-- panel -->
             <div class="panel panel-success" style="margin-top:30px;">
                <div class="panel-heading">
                    <h4><span class="glyphicon glyphicon-user"></span> Hai Selamat Datang <?php echo $_SESSION['USERNAME'] ?></h4>
                </div>

                <div class="form-inline" style="margin:10px">
                    <div class="form-group">
                        <label for="cif">Masukan CIF</label>&nbsp;&nbsp; 
                        <input type="text" id="cif" class="form-control" name="cif" maxlength="15" size="15" required>&nbsp;&nbsp;
                        <button id="tampilkan" class="btn btn-primary"><!--<i class="glyphicon glyphicon-search"></i>--> Generate</button>
                    </div>
                </div>

                <div style="margin:10px; border:1px solid #ccc; padding:10px; line-height:10px;">

                        <div id="loader"></div>
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="tampildata">
                            <!-- jika ada data tampilkan -->
                            <tbody>
                            </tbody>
                        </table>
                        </div><br /><br/>

                        <div id="tampildata2">

						</div>

                </div>

            </div>
            <!-- end panel heading -->

        </div>
        <!-- panel -->


    </div>
    <!-- /.row -->
</div>
<!-- /.End Konten Isi -->

<?php //echo $_SESSION['ID'] ?><!--<br />-->
<?php //echo $_SESSION['USERNAME'] ?><!--<br />-->
<?php //echo $_SESSION['EMAIL'] ?><!--<br />-->
<?php //echo $_SESSION['BRANCH_NAME'] ?><!--<br />-->
<?php //echo $_SESSION['ROLE_ID'] ?><!--<br />-->
<?php //echo $_SESSION['NAMA_ROLE'] ?><!--<br />-->


<?php
	$this->load->view('layout_phr_nasabah/footer.php'); 	
?>

<!-----------------script ajax------------------>
<script type="text/javascript">

//-- load agar pertama kali dibuka langsung focus ke inputan cif-//
window.onload = function() {
  var input = document.getElementById("cif").focus();
}
//-- load agar pertama kali dibuka langsung focus ke inputan cif-//

$(document).ready(function(){

    $("#tampilkan").click(function(){
        if($("#cif").val() == ''){
            alert ('CIF Tidak Boleh Kosong');
            //cif.focus("cif");
            document.getElementById('cif').focus();
            return false;
        }
        else {
            //$("#formlogin").submit();

        }

        var cif = $("#cif").val();

        $('#tampildata').empty();
        $('#tampildata2').empty();

        $('#loader').fadeOut();
        $('#loader').html('<img src="<?php echo loader.'loader2.gif'; ?>"> ');
        $('#loader').fadeIn(500);

        $.ajax({
            //url:'http://localhost/webprogramming/php_webservice/getdatabuku.php',
            url:'http://192.168.66.7/DBServices/phr_service.php',
            dataType:'json',
            type:"POST",
            data:"cif="+cif,
            cache:false,
            success : function(data){

                $.ajax({
                    url: "<?php echo site_url('home_phr_nasabah/tambah_phr'); ?>",//repair
                    type: 'POST',
                    data:"cif="+cif,
                    // success: function(msg) {
                          // alert("success..!! or any stupid msg");
                    // }
                });

                $.ajax({
                       url:"<?php echo site_url('home_phr_nasabah/show_program');?>",
                       type:"POST",
                       data:"cif="+cif,
                       cache:false,
                       success:function(html){
                           $("#tampildata2").html(html);

                       }
                   })

                var trHTML = '<thead><tr><th colspan=2 >PRODUK YANG SUDAH DIMILIKI</th></tr><tr><th class=text-center>Jenis Produk</th><th class=text-center>Nama Produk</th></tr></thead>';
                $.each(data, function (index,element) {
                    trHTML +=
                    '<tr><td>'  + element.item_produk +
                    '</td><td>' + element.nama_produk +
                    '</td></tr>';
                });


                $('#tampildata').append(trHTML);



                $('#loader').html("").hide();

            }

        });






    })
})


</script>
<!-----------------script ajax------------------>

<!-----------------style loader ajax------------------>
<style>
    #loader {
        text-align: center;
    }
    .head-dimiliki{
        background-color: orange;
    }
</style>
<!-----------------style loader ajax------------------>
