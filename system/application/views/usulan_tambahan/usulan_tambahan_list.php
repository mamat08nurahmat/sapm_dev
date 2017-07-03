<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
<!---
<link href="<?php echo $this->config->item('base_url') ?>assets/jquery/jquery-ui-1.11.2/jquery-ui.min.css" rel="stylesheet" type="text/css"/>	
<script type="text/javascript" src="<?php echo $this->config->item('base_url') ?>assets/jquery/jquery-1.11.2.min.js"></script>
--->		
<!--

        <link rel="stylesheet" href="<?php echo base_url('assets123/bootstrap/css/bootstrap.min.css') ?>"/>
        <link rel="stylesheet" href="<?php echo base_url('assets123/datatables/dataTables.bootstrap.css') ?>"/>
        <link rel="stylesheet" href="<?php echo base_url('assets123/datatables/dataTables.bootstrap.css') ?>"/>
-->		
       <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('base_url') ?>assets123/bootstrap/css/bootstrap.min.css"/>
       <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('base_url') ?>assets123/datatables/dataTables.bootstrap.css"/>
		
        <style>
            .dataTables_wrapper {
                min-height: 500px
            }
            
            .dataTables_processing {
                position: absolute;
                top: 50%;
                left: 50%;
                width: 100%;
                margin-left: -50%;
                margin-top: -25px;
                padding-top: 20px;
                text-align: center;
                font-size: 1.2em;
                color:grey;
            }
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <h2 style="margin-top:0px">Usulan_tambahan List</h2>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 4px"  id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-4 text-right">
        <?php echo anchor(site_url('usulan_tambahan/create'), 'Create', 'class="btn btn-primary"'); ?>
		<?php echo anchor(site_url('usulan_tambahan/excel'), 'Excel', 'class="btn btn-primary"'); ?>
		<?php echo anchor(site_url('usulan_tambahan/word'), 'Word', 'class="btn btn-primary"'); ?>
	    </div>
        </div>
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
           <th width="80px">ID</th>
		    <th>USER NAME</th>
		    <th>EMAIL</th>

			
		    <th width="200px">Action</th>
                </tr>			
<!----
                <tr>
           <th width="80px">No</th>
		    <th>Jenis</th>
		    <th>Cif</th>
		    <th>Jenis Cif</th>
		    <th>Nama Nasabah</th>
		    <th>Cif Utama</th>
		    <th>Hubungan Degan Utama</th>
		    <th>Status</th>
		    <th>Approval</th>
		    <th>Tanggal Kirim</th>
		    <th width="200px">Action</th>
                </tr>
--->				
            </thead>
	    
        </table>
<!---
<script type="text/javascript" src="<?php echo $this->config->item('base_url') ?>assets/jquery/jquery-1.11.2.min.js"></script>
-->		
        <script src="<?php echo $this->config->item('base_url') ?>assets123/js/jquery-1.11.2.min.js"></script>
        <script src="<?php echo $this->config->item('base_url') ?>assets123/datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo $this->config->item('base_url') ?>assets123/datatables/jquery.dataTables.js"></script>
		
        <script type="text/javascript">
            $(document).ready(function() {
                $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
                {
                    return {
                        "iStart": oSettings._iDisplayStart,
                        "iEnd": oSettings.fnDisplayEnd(),
                        "iLength": oSettings._iDisplayLength,
                        "iTotal": oSettings.fnRecordsTotal(),
                        "iFilteredTotal": oSettings.fnRecordsDisplay(),
                        "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                        "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                    };
                };

                var t = $("#mytable").dataTable({
                    initComplete: function() {
                        var api = this.api();
                        $('#mytable_filter input')
                                .off('.DT')
                                .on('keyup.DT', function(e) {
                                    if (e.keyCode == 13) {
                                        api.search(this.value).draw();
                            }
                        });
                    },
                    oLanguage: {
                        sProcessing: "loading..."
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {"url": "usulan_tambahan/json", "type": "POST"},
                    columns: [


                        {
                            "data": "id",
                            "orderable": false
                        },
                        {"data": "user_name"},
                        {"data": "email"},

                        {
                            "data" : "action",
                            "orderable": false,
                            "className" : "text-center"
                        }
					
/*
                        {
                            "data": "id",
                            "orderable": false
                        },
                        {"data": "jenis"},
                        {"data": "cif"},
                        {"data": "jenis_cif"},
                        {"data": "nama_nasabah"},
                        {"data": "cif_utama"},
                        {"data": "hubungan_degan_utama"},
                        {"data": "status"},
                        {"data": "approval"},
                        {"data": "tanggal_kirim"},
                        {
                            "data" : "action",
                            "orderable": false,
                            "className" : "text-center"
                        }
*/						
                    ],
                    order: [[0, 'desc']],
                    rowCallback: function(row, data, iDisplayIndex) {
                        var info = this.fnPagingInfo();
                        var page = info.iPage;
                        var length = info.iLength;
                        var index = page * length + (iDisplayIndex + 1);
                        $('td:eq(0)', row).html(index);
                    }
                });
            });
        </script>
<!--
-->		
		
    </body>
</html>