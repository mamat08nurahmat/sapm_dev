<?php
    $this->load->view('layout_phr_nasabah/header.php');
?>
	<!-- jQuery -->
	<script src="<?php echo NEWJS.'jquery.js' ?>"></script>
    <!-- datetimepicker -->
	<script src="<?php echo NEWJS.'moment.js' ?>"></script>
	<script src="<?php echo NEWJS.'bootstrap-datetimepicker.min.js' ?>"></script>	
	<script type="text/javascript">
    	

    	// datepicker
    	$(function(){
			
    		// $("#tanggal1").datepicker({
    			// format: 'd-m-yyyy'
    		// });
    		$('#tanggal1').datetimepicker({
                format: 'DD-MMM-YYYY',

    			// //locale: 'id'
            });

            $('#tanggal').datetimepicker({
                format: 'DD-MMM-YYYY',

    			// //locale: 'id'
            });

    		$("#cari").click(function(){
            $("#myModal2").modal("show");
			return false;
        })

		$("#cariunit").keyup(function(){
            var cariunit = $("#cariunit").val();

            $.ajax({
                url:"<?php echo site_url('phr_user/cari_unit');?>",
                type:"POST",
                data:"cariunit="+cariunit,
                cache:false,
                success:function(html){
                    $("#tampilunit").html(html);
                }
            })
        })


		$('body').on('click', '.tambah', function(){
            var id_unit   = $(this).attr("id_unit");

            $("#id_unit").val(id_unit);

            $("#myModal2").modal("hide");

        })



    	})
    </script>
	<!-- end datetimepicker -->

<!-- Konten Isi -->
<div class="container">

    <!-- Marketing Icons Section -->
    <div class="row">
        <div class="col-lg-12">
            <br />
            <?php
                $pesan = $this->session->flashdata('pesan');
                if (! empty($pesan)){
                    echo $pesan;
                }
            ?>

            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#8FC0D8; color:#fff;"><strong>EDIT USERTAX</strong></div><br />
                <div class="table-responsive" style="margin:10px; overflow:visible">
                     <form class="form-horizontal" role="form" id="frmLogin" method="post"  action="<?php echo site_url('phr_user/update_user'); ?>">
                        <div class="form-group">
                          <label class="control-label col-sm-2" for=""><p class="text-left">NPP</p></label>
                          <div class="col-sm-3">
                            <input type="text" name="npp" id="npp" maxlength="7" class="form-control" value="<?php echo $usertax->ID; ?>" readonly>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-sm-2" for=""><p class="text-left">Nama User</p></label>
                          <div class="col-sm-5">
                            <input type="text" name="nama_user"  class="form-control" value="<?php echo $usertax->USERNAME; ?>" required>
                          </div>

                        </div>

                        <!--
                        <div class="form-group">
                          <label class="control-label col-sm-2" for=""><p class="text-left">Posisi</p></label>
                          <div class="col-sm-3">
                            <input type="text" name="posisi"  class="form-control" >
                          </div>
                        </div>-->


                        <div class="form-group">
                          <label class="control-label col-sm-2" for=""><p class="text-left">Email</p></label>
                          <div class="col-sm-5">
                            <input type="text" name="email"  class="form-control" value="<?php echo $usertax->EMAIL; ?>" required>
                          </div>

                        </div>


                        <div class="form-group">
                          <label class="control-label col-sm-2" for=""><p class="text-left">Unit ID</p></label>
                          <div class="col-sm-4">
                            <div class="input-group"> <!-- input group -->
                                <input type="text" id="id_unit" name="id_unit" class="form-control" placeholder="" value="<?php echo $usertax->UNIT_ID; ?>" required>
                                <span class="input-group-btn">
                                    <button id="cari" type="button" class="btn btn-info"><span class="glyphicon glyphicon-search"></span> Search</button>

                                </span>
                            </div>* clik tombol untuk mencari unit_id
                          </div>



                        </div>

                        <div class="form-group">
                          <label class="control-label col-sm-2" for=""><p class="text-left">Level</p></label>
                          <div class="col-sm-3">
                                <select class="form-control" name="level" required>
                                    <option value="">- Pilih Level -</option>
                                    <?php

                                        foreach($lookuprole as $row)
                                        {
                                            ?>
                                            <option value="<?php echo $row->ID; ?>" <?php echo set_value('level', $usertax->ROLE_ID) == $row->ID ? "selected" : "";  ?>><?php echo $row->NAMA_ROLE; ?></option>
                                            <?php
                                        }
                                    ?>

                                </select>
                          </div>
                        </div>

                        <div class="form-group ">
                          <label class="control-label col-sm-2" for="pwd"><p class="text-left">Status</p></label>
                          <div class="col-sm-10">
                            <div class="checkbox">
                                <label class="radio-inline"><input type="radio" name="status" value="1"
                                <?php echo set_value('status', $usertax->STATUS) == 1 ? "checked" : "";  ?>>Aktif</label>
                                <label class="radio-inline"><input type="radio" name="status" value="0"
                                <?php echo set_value('status', $usertax->STATUS) == 0 ? "checked" : "";  ?>>Non Aktif</label>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" name="simpan" id="simpan" class="btn btn-primary" value="Simpan" />
                            <input type="button" name="batal" class="btn btn-warning" onclick=self.history.back() value="Batal" />
                          </div>
                        </div>


                      </form>
                 </div>
             </div>

        </div>
        <!-- end col -->


    </div>
    <!-- /.row -->
</div>
<!-- /.End Konten Isi -->


<!-- Modal Cari Nasabah -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Cari Unit ID</h4>
      </div>
      <div class="modal-body">
        <!--<label class="col-lg-4 control-label">Cari Nama Nasabah</label>-->
        <input type="text" name="cariunit" id="cariunit" class="form-control" placeholder="Ketikan Unit ID">

        <div id="tampilunit"></div>

      </div>

      <br /><br />
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary" id="konfirmasi">Hapus</button>-->
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<!-- End Modal Cari Nasabah -->

<?php
	$this->load->view('layout_phr_nasabah/footer.php'); 	
?>

<!-----------------script ajax------------------>
<script type="text/javascript">

	$(document).ready(function(){


		
		//$('#rupiah').maskMoney({prefix:'', thousands:'.', decimal:',', precision:0});

		$('#simpan').click(function(){
			if(validation() != ''){ alert(validation()); }
				else $("#frmLogin").submit();
			});
			
		function validation(){
				var msg = '';
				msg =  valid('#npp', 'NPP User');
				//if(! checkMail($('#email_contact').val() + $('#email_ext').val() )){ msg += 'Pls insert valid email ! \n'; }
				//if(! checkNumber($('#COST_OF_LIVING').val())){ msg += 'Biaya hidup/bulan harus angka! \n'; }
				//if(! checkNumber($('#CHILDREN').val())){ msg += 'Jumlah anak harus angka! \n'; }
				//msg += valid('#PHONE_1', 'Telepon');
				//if ($("#ry_rtgs").is(":checked")) {
					//msg += valid('#REFFERAL_LEADS_ID', 'Refferal id');
					//msg += valid('#BRANCH', 'Cabang Tujuan');
				}
				return msg;
			}
		
		function valid(frm, nama){
				var msg = '';
				if($(frm).val() == '' || $(frm).val() == '0')
				msg = nama + ' Tidak boleh kosong ! \n';
				msg = msg.replace('#','');
				return msg;
			}
	})
</script>
<!-----------------script ajax------------------>

<script type="text/javascript">
    function confirmDelete() {
        return confirm('Apakah anda yakin ingin menghapus data user');
    }
</script>
