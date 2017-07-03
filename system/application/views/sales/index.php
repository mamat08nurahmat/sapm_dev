<?php $this->load->view('template/header') ?>	
<?php $this->load->view('template/topbar') ?>	
<?php $this->load->view('template/sidebar') ?>	
<!----------------------------------------------------->
    <!-- Main content -->
   	<section class="content">
        <!-- START CUSTOM TABS -->

	<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> LEADS MANAGEMENT 
    </div>


</section>
<!-- ----------- -->
	<?php if($_SESSION['USER_LEVEL']=='CABANG' || $_SESSION['USER_LEVEL']=='PEMIMPIN_CABANG'|| $_SESSION['USER_LEVEL']=='PIMPINAN_CABANG' || $_SESSION['USER_LEVEL']=='SUPERVISOR' ) { ?>
	<div id="dlg_list_sales" title="Pilih Sales" style="diplay:none">
		<div id="form_input">
		<form method="post" action="<?php echo site_url('sales_ajax/append_sales_propensity');?>" id="frm_append_sales">
			<select name="sales_id" style="width:100%;padding:2px 0px 2px 2px">
				<option value=""></option>
				<?php foreach($list_sales as $value=>$text) { ?>
				<option value="<?php echo $value;?>"><?php echo $text;?></option>
				<?php } ?>
			</select>
			<div id="tampung_buat_cif" style="display:none">
				<input type="hidden" name="id[]" value="" />
			</div>
			<input type="submit" style="display:none" value="Submit" />
		</form>
		</div>
		
		<div id="loading_box" style="display:none">
			<img src="<?php echo ICONS;?>loading_bar.gif" alt="Loading...." width="350" height="19" />
		</div>
	</div>
	<?php } ?>

	<?php if($_SESSION['USER_LEVEL']=='CABANG' || $_SESSION['USER_LEVEL']=='PEMIMPIN_CABANG'|| $_SESSION['USER_LEVEL']=='PIMPINAN_CABANG' || $_SESSION['USER_LEVEL']=='SUPERVISOR') { ?>
	<div id="dlg_list_sales2" title="Pilih Sales" style="diplay:none">
		<div id="form_input2">
		<form method="post" action="<?php echo site_url('sales_ajax/append_sales_500046');?>" id="frm_append_sales2">
			<select name="sales_id" style="width:100%;padding:2px 0px 2px 2px">
				<option value=""></option>
				<?php foreach($list_sales as $value=>$text) { ?>
				<option value="<?php echo $value;?>"><?php echo $text;?></option>
				<?php } ?>
			</select>
			<div id="tampung_buat_cif2" style="display:none">
				<input type="hidden" name="id[]" value="" />
			</div>
			<input type="submit" style="display:none" value="Submit" />
		</form>
		</div>
		
		<div id="loading_box2" style="display:none">
			<img src="<?php echo ICONS;?>loading_bar.gif" alt="Loading...." width="350" height="19" />
		</div>
	</div>
	<?php } ?>

	
	<?php if($_SESSION['USER_LEVEL']=='CABANG' || $_SESSION['USER_LEVEL']=='PEMIMPIN_CABANG'|| $_SESSION['USER_LEVEL']=='PIMPINAN_CABANG' || $_SESSION['USER_LEVEL']=='SUPERVISOR') { ?>
	<div id="dlg_list_sales3" title="Pilih Sales" style="diplay:none">
		<div id="form_input3">
		<form method="post" action="<?php echo site_url('sales_ajax/append_sales_offensive');?>" id="frm_append_sales3">
			<select name="sales_id" style="width:100%;padding:2px 0px 2px 2px">
				<option value=""></option>
				<?php foreach($list_sales as $value=>$text) { ?>
				<option value="<?php echo $value;?>"><?php echo $text;?></option>
				<?php } ?>
			</select>
			<div id="tampung_buat_cif3" style="display:none">
				<input type="hidden" name="id[]" value="" />
			</div>
			<input type="submit" style="display:none" value="Submit" />
		</form>
		</div>
		
		<div id="loading_box3" style="display:none">
			<img src="<?php echo ICONS;?>loading_bar.gif" alt="Loading...." width="350" height="19" />
		</div>
	</div>
	<?php } ?>
	
<!------------- -->

	
            <!-- Custom Tabs -->
 <div class="nav-tabs-custom">

			  <ul class="nav nav-pills">

			  
			  <?php
			if($_SESSION['USER_LEVEL']=='SALES' && ($_SESSION['SALES_ID'] < 9||$_SESSION['SALES_ID'] >19))
			{  
			  ?>
                <li class="active"><a href="#tab_1" data-toggle="tab">Leads offensive</a></li>
                <li><a href="#tab_2" data-toggle="tab">Leads Propensity</a></li>
                <li><a href="#tab_3" data-toggle="tab">Leads 500046</a></li> 
				<li><a href="#tab_4" data-toggle="tab">Leads Kelolaan</a></li>
                <li><a href="#tab_5" data-toggle="tab">Leads Prospek</a></li>
		<?php } ?>			  

              </ul>
			 
			 
			 
<!------
----->			 
<div class="tab-content">

    <div class="tab-pane active" id="tab_1">

<h5><strong>DATA LEADS OFFENSIVE</strong></h5>
        
        <table id="table1" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
			
                <tr>
                    <th>ID</th>
                    <th>CIF</th>
                    <th>NAMA</th>
                    <th>No HP</th>
                    <th>PROGRAM</th>
                    <th>PRODUK</th>
                    <th style="width:50px;">Action</th>
                </tr>

            </thead>
            <tbody>
            </tbody>

        </table>

    </div>


    <div class="tab-pane " id="tab_2">
        
                <h5><strong>DATA LEADS PROPENSITY</strong></h5>

        <table id="table2" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>CIF KEY</th>
                    <th>EMAIL</th>                    
                    <th>BRANCH</th>
                    <th>BNI HP NO</th>
                    <th>PROGRAM PENJUALAN</th>
					<th>PRODUK</th>
                    <th>JANGKA WAKTU PR</th>
                    <th style="width:50px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>


        </table>


    </div>

    <div class="tab-pane " id="tab_3">
        
                <h5><strong>DATA LEADS 150046</strong></h5>

        <table id="table3" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>SAPM_DATE</th>
                    <th>CIF</th>
                    <th>NAMA</th>
                    <th>NO HP</th>
                    <th>KOTA</th>
                    <th>JENIS_PRODUK</th>
                    <th>KODE_CABANG</th>
            </thead>
                    <th style="width:50px;">Action</th>
                </tr>
            <tbody>
            </tbody>


        </table>


    </div>

    <div class="tab-pane " id="tab_4">
        
                <h5><strong>DATA LEADS KELOLAAN</strong></h5>

        <table id="table4" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>CIF</th>
                    <th>NAMA</th>
                    <th>UMUR</th>
                    <th>TOTAL AUM</th>
                    <th>TOTAL LOAN</th>
                    <th>SALES</th>
					<th>CABANG</th>
                    <th style="width:50px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>


        </table>


    </div>

    <div class="tab-pane " id="tab_5">
        
                    <h5><strong>DATA LEADS PROSPEK</strong></h5>

        <table id="table5" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
               <tr>
                    <th>ID</th>
                    <th>CIF</th>
                    <th>NAMA</th>
                    <th>UMUR</th>
                    <th style="width:50px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

        </table>


    </div>


</div>


</div>
         <!-- / end class .row -->

		 

<!--------------------->
</section>
<!--------------------->


<script src="http://192.168.3.14/new_sapm/assets/jquery/jquery-2.1.4.min.js"></script>
<script src="http://192.168.3.14/new_sapm/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="http://192.168.3.14/new_sapm/assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="http://192.168.3.14/new_sapm/assets/datatables/js/dataTables.bootstrap.js"></script>
<script src="http://192.168.3.14/new_sapm/assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>


<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function() {
	
//------------------
    //datatables 1
    table = $('#table1').DataTable({ 
	"searching" : false,

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('sales_ajax_new/ajax_list_tab_1')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],

    });
//------------------

//------------------
    //datatables 2
    table = $('#table2').DataTable({ 
	"searching" : false,

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('sales_ajax_new/ajax_list_tab_2')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],

    });

	
//------------------
    //datatables 3
    table = $('#table3').DataTable({ 
	"searching" : false,

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('sales_ajax_new/ajax_list_tab_3')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],

    });

	
//------------------
    //datatables 4
    table = $('#table4').DataTable({ 
	"searching" : false,

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('sales_ajax_new/ajax_list_tab_4')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],

    });


//------------------
    //datatables 5
    table = $('#table5').DataTable({ 
	"searching" : false,

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('sales_ajax_new/ajax_list_tab_5')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],

    });
	
//-----------------------------------	



    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });

    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });

});



function view_data(id)
{
	       $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('VIEW DATA'); // Set title to Bootstrap modal title

//	alert(id);
//    save_method = 'update';
/*
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
*/

    //Ajax Load data from ajax
/*
    $.ajax({
        url : "<?php echo site_url('sales_ajax_new/ajax_view/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			
    $('.form-control').attr('readonly',true); // read only
	
            $('[name="ID"]').val(data.ID);
            $('[name="CIF"]').val(data.ID);
            $('[name="NAMA"]').val(data.ID);
            $('[name="NO_HP"]').val(data.ID);
            $('[name="PROGRAM"]').val(data.ID);
            $('[name="PRODUK"]').val(data.ID);

            $('[name="gender"]').val(data.ID);
//            $('[name="address"]').val(data.address);
//            $('[name="dob"]').datepicker('update',data.dob);
			
            $('#modal_form_tab_1').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('VIEW DATA'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
*/
/*
*/	
}

//-----------------
function view_data_tab_1(id)
{
	//alert("view_data_tab_2");
	       $('#modal_form1').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('VIEW DATA LEADS '); // Set title to Bootstrap modal title
/*

//	alert(id);
//    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
*/

    //Ajax Load data from ajax
/*
    $.ajax({
        url : "<?php echo site_url('sales_ajax_new/ajax_view/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			
    $('.form-control').attr('readonly',true); // read only
	
            $('[name="ID"]').val(data.ID);
            $('[name="CIF"]').val(data.ID);
            $('[name="NAMA"]').val(data.ID);
            $('[name="NO_HP"]').val(data.ID);
            $('[name="PROGRAM"]').val(data.ID);
            $('[name="PRODUK"]').val(data.ID);

            $('[name="gender"]').val(data.ID);
//            $('[name="address"]').val(data.address);
//            $('[name="dob"]').datepicker('update',data.dob);
			
            $('#modal_form_tab_1').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('VIEW DATA'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
*/
/*
*/	
}
//-----------------
function view_data_tab_2(id)
{
	//alert("view_data_tab_2");
/*
	       $('#modal_form2').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('VIEW DATA LEADS PROPENSITY'); // Set title to Bootstrap modal title
*/	
	//alert(id);
/*
//    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
*/

    //Ajax Load data from ajax
    $.ajax({
//	       url : "<?php echo site_url('person/ajax_edit/')?>/" + id,

        url : "<?php echo site_url('sales_ajax_new/ajax_view2/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			
    $('.form-control').attr('readonly',true); // read only
	
	/*
            $('[name="ID"]').val(data.ID);
            $('[name="ID"]').val(data.ID);
            $('[name="ID"]').val(data.ID);
            
			
	*/

	
            $('#modal_form2').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('VIEW DATA LEADS PROPENSITY'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
/*
*/
/*
*/
/*
*/	
}
//----------------
//-----------------
function view_data_tab_5(id)
{
/*
		var urls = '<?php echo site_url("/sales/view_cust_ind/0")?>'+'/'+id;	
			window.location = urls ;
*/	
	

	       $('#modal_form5').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('LEADS KELOLAAN'); // Set title to Bootstrap modal title

          //  $('#btnSave').display('none'); // Set title to Bootstrap modal title


var urls = '<?php echo site_url('/sales_ajax_new/get_view_modal5/')?>/'+id;			
//var urls = '<?php echo site_url('/db/tabel/')?>';			
$("#div1").load(urls);
/*
*/	

 
 /*
			
console.log("view_data_tab_5");	
console.log(id);	
*/
//	alert("view_data_tab_5");
//	alert(id);
/*
//    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
*/

	/*
    //Ajax Load data from ajax
    $.ajax({
//	       url : "<?php echo site_url('person/ajax_edit/')?>/" + id,

        url : "<?php echo site_url('sales_ajax_new/ajax_view2/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			
    $('.form-control').attr('readonly',true); // read only
	
            $('[name="ID"]').val(data.ID);
            $('[name="ID"]').val(data.ID);
            $('[name="ID"]').val(data.ID);
            
			

	
            $('#modal_form2').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('VIEW DATA LEADS PROPENSITY'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
	*/
/*
*/
/*
*/
/*
*/	
}


function add_data_tab_5()
{
			var urls = '<?php echo site_url("/sales/edit_cust_ind_pros")?>';
			alert('PASTIKAN CIF TERISI SESUAI ICONS UNTUK NASABAH EXISTING DAN NAMA NASABAH TERISI SESUAI DENGAN KTP/NAMA PERUSAHAAN UNTUK NASABAH BARU');
			window.location = urls ; 
/*
*/	
//-----------------
/*
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form5').modal('show'); // show bootstrap modal
    $('.modal-title').text('LEADS PROSPEK'); // Set Title to Bootstrap modal title
*/	
//alert('PASTIKAN CIF TERISI SESUAI ICONS UNTUK NASABAH EXISTING DAN NAMA NASABAH TERISI SESUAI DENGAN KTP/NAMA PERUSAHAAN UNTUK NASABAH BARU');
//var urls = '<?php echo site_url('/db/tabel/')?>';			
/*
var urls = '<?php echo site_url('/sales_ajax_new/get_add_modal5/')?>';			
$("#div1").load(urls);
*/	
		
}

function edit_data_tab_5(id)
{
			var urls = '<?php echo site_url("/sales/edit_cust_ind/1")?>'+'/'+id;
			window.location = urls ; 	
	
/*
	alert(id);
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('person/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id"]').val(data.id);
            $('[name="firstName"]').val(data.firstName);
            $('[name="lastName"]').val(data.lastName);
            $('[name="gender"]').val(data.gender);
            $('[name="address"]').val(data.address);
            $('[name="dob"]').datepicker('update',data.dob);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
*/	
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('person/ajax_add')?>";
    } else {
        url = "<?php echo site_url('person/ajax_update')?>";
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function delete_data_tab_5(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('person/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

</script>

<!-- Bootstrap modal Tab 2-->
<div class="modal fade" id="modal_form2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
					
                    <div class="form-body">
					
					

			<h3>CIF KEY : <?php //echo $result->CIF_KEY;?></h3>
			
            <table width="100%" border="0">
				<tr>
					<td width="50%" colspan="3" style="background-color:#eeeeee;padding:3px;font-weight:bold">Data Pribadi Nasabah</td>
					<td width="50%" colspan="3" style="background-color:#eeeeee;padding:3px;font-weight:bold">Data Bisnis</td>
				</tr>
				
				<tr>
					<td style="padding:3px">CIF</td>
					<td style="padding:3px;width:3%;text-align:center;">:</td>
					<td style="padding:3px;"><?php //echo $result->CIF_KEY;?></td>
					<td style="padding:3px;">Estimasi Penjualan DPK</td>
					<td style="padding:3px;width:3%text-align:center;">:</td>
					<td style="padding:3px;text-align:right"><?php //echo number_format($result->ESTIMASI_DPK, 2, ',', '.');?></td>
				</tr>
				
				<tr>
					<td style="padding:3px">Nama Nasabah</td>
					<td style="padding:3px;width:3%;text-align:center;">:</td>
					<td style="padding:3px;"><?php //echo $result->NAMA;?></td>
					<td style="padding:3px;">Estimasi Penjualan Loan</td>
					<td style="padding:3px;width:3%text-align:center;">:</td>
					<td style="padding:3px;text-align:right"><?php //echo number_format($result->ESTIMASI_LOAN, 2, ',', '.');?></td>
				</tr>
				
				<tr>
					<td style="padding:3px">Life Time</td>
					<td style="padding:3px;width:3%;text-align:center;">:</td>
					<td style="padding:3px;"><?php //echo $result->LIFE_TIME;?></td>
					<td style="padding:3px;">Estimasi Penjualan Investasi</td>
					<td style="padding:3px;width:3%text-align:center;">:</td>
					<td style="padding:3px;text-align:right"><?php //echo number_format($result->ESTIMASI_INVESTASI, 2, ',', '.');?></td>
				</tr>
				
				<tr>
					<td style="padding:3px">No Handphone</td>
					<td style="padding:3px;width:3%;text-align:center;">:</td>
					<td style="padding:3px;"><?php //echo $result->HANDPHONE;?></td>
					<td style="padding:3px;">Macro Segment</td>
					<td style="padding:3px;width:3%text-align:center;">:</td>
					<td style="padding:3px;text-align:right"><?php //echo $result->MACRO_SEGMENT;?></td>
				</tr>
				
				<tr>
					<td style="padding:3px">Alamat Terkini</td>
					<td style="padding:3px;width:3%;text-align:center;">:</td>
					<td style="padding:3px;"><?php //echo $result->ALAMAT;?></td>
					<td style="padding:3px;">Micro Segment</td>
					<td style="padding:3px;width:3%text-align:center;">:</td>
					<td style="padding:3px;text-align:right"><?php //echo $result->MICRO_SEGMENT;?></td>
				</tr>
				
				<tr><td colspan="6" height="50px"></td></tr>
				
				<tr>
					<td width="50%" colspan="3" style="background-color:#eeeeee;padding:3px;font-weight:bold">Data Sales</td>
					<td width="50%" colspan="3" style="background-color:#eeeeee;padding:3px;font-weight:bold">Data Program</td>
				</tr>
				
				<tr>
					<td style="padding:3px">BNI Sales ID</td>
					<td style="padding:3px;width:3%;text-align:center;">:</td>
					<td style="padding:3px;"><?php 
						if($_SESSION['USER_LEVEL']=='PEMIMPIN_CABANG' || $_SESSION['USER_LEVEL']=='PIMPINAN_CABANG' || $_SESSION['USER_LEVEL']=='CABANG') {
							/*//echo '<select name="id" style="width:200px;padding:2px 0px 2px 2px" onchange=" changeSales(this.value)">';
							//echo '<option value="">--Pilih Sales--</option>';
							foreach($list_sales as $value=>$text) {
								//echo '<option value="'.$value.'" '.($result->SALES_ID==$value? 'checked="checked"':'').'>'.$text.'</option>';
							}
							//echo '</select>';*/
							//echo $result->SALES_ID;
						} elseif(!empty($result->SALES_ID)) {
							//echo $result->SALES_ID;
						} else {
							//echo '-';
						}
					?></td>
					<td style="padding:3px;">Program Penjualan</td>
					<td style="padding:3px;width:3%text-align:center;">:</td>
					<td style="padding:3px;text-align:right"><?php //echo $result->PROGRAM_NAME;?></td>
				</tr>
				
				<tr>
					<td colspan="3"></td>
					<td style="padding:3px;">Jangka Waktu Program</td>
					<td style="padding:3px;width:3%text-align:center;">:</td>
					<td style="padding:3px;text-align:right"><?php //echo $result->EXPIRED_PROGRAM;?></td>
				</tr>
				
				<tr>
					<td colspan="3"></td>
					<td style="padding:3px;">Produk</td>
					<td style="padding:3px;width:3%text-align:center;">:</td>
					<td style="padding:3px;text-align:right"><?php //echo $result->PRODUK;?></td>
				</tr>
				
            </table>
					
<!---
                        <div class="form-group">
                            <label class="control-label col-md-3">ID</label>
                            <div class="col-md-9">
                                <input name="ID"  class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
						
                        <div class="form-group">
                            <label class="control-label col-md-3">ID</label>
                            <div class="col-md-9">
                                <input name="ID"  class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">ID</label>
                            <div class="col-md-9">
                                <input name="ID"  class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>						
--->					

						
                    </div>
                </form>
            </div>
            <div class="modal-footer">
			<!---
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
			--->
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->




<!-- Bootstrap modal Tab 5-->
<div class="modal fade" id="modal_form5" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
<!---
-->		
<!---
-->		
			
<div id="div1"><h2>Loading...</h2></div>			

<!---
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
					
                    <div class="form-body">
					
					
                        <div class="form-group">
                            <label class="control-label col-md-3">ID</label>
                            <div class="col-md-9">
                                <input name="ID"  class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
						
                        <div class="form-group">
                            <label class="control-label col-md-3">ID</label>
                            <div class="col-md-9">
                                <input name="ID"  class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">ID</label>
                            <div class="col-md-9">
                                <input name="ID"  class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>						

						
                    </div>
                </form>
--->					
<!---
-->		
				
            </div>
			
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
<!----
--->			
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->


<!-- /.content -->


<!------------------------------------------------------------->
<?php $this->load->view('template/js') ?>	
<?php $this->load->view('template/footer') ?>	
