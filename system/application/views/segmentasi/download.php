<?php $this->load->view('default/header') ?>	
<td  valign="top" align="left">

<script type="text/javascript">
	$(function() {
		//------------------------------------
		//	set tabbed windows	
		//------------------------------------	
		$(function() { $("#tabs").tabs(); });
	
		//------------------------------------
		//	Button Action
		//------------------------------------		
		$('#download').click(function(){
			getReport();	
		})
	
		//------------------------------------
		//	Ajax download
		//------------------------------------					
		function getReport(){
			var month 	= $('#MONTH').val(); 
			var year 	= $('#YEAR').val(); 
			var id 		= $('#BRANCH').val();
			var owner	= $('#OWNER').val();

			var urls = '<?php echo site_url('/csv/export/')?>/'+id + '/' + month + '/' +year + '/' +owner; 
			$("#report").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
			window.location = urls;
			$("#report").html("Window download akan otomatis tampil, jika tidak anda bisa klik disini <a href='"+urls+"'>download</a> ");
		}
		
	});
</script>


<div id='content_x'>
	<div id="tabs">
        <ul>
            <li><a href="#tabs-1">DOWNLOAD DATA REALISASI</a></li>
        </ul>
        <div id="tabs-1">
            <form action="" method="post" enctype="application/x-www-form-urlencoded" name="frmReport" id="frmReport">
            <table width="" border="0" cellspacing="5" cellpadding="0" >
              <tr>
                    <td align="left">Cabang</td>
                    <td>:</td>
                    <td align="left">
                    	<?php echo form_dropdown('BRANCH',$this->_csv->get_list_cabang(),'0','id="BRANCH"');?>
                    </td>
                </tr>
              <tr>
                    <td align="left">Tahun</td>
                    <td>:</td>
                    <td align="left">
                    	<select name="YEAR" id="YEAR">
                    	<?php 
							$date = getdate(strtotime(NOW));
							$year = $date['year'];
							for($i=($year-1);$i<=$year;$i++)
							{
								$selected = ($i == $year)?'selected':'';
								echo "<option value='$i' $selected>$i</option>\n";
							}
						?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="left">Bulan</td>
                    <td>:</td>
                    <td align="left">
                    <?php 
                        $bulan = array(	'1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April',
                                        '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus',
                                        '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
                        $html  = '';
                        $html .= "<select name='MONTH' id='MONTH' style='width:110px'>";
                        $month2 = date('m')*1;
						$month1 = (date('m') === 1)?12:(date('m')*1)-1;						
						$html .= "<option value='$month1'>".$bulan[$month1]."</option>"; 	
						$html .= "<option value='$month2' selected>".$bulan[$month2]."</option>"; 	
                        $html .= "</select>";
                        echo $html;
                    ?>
                    </td>
                </tr>
                <tr>
                	 <td align="left">Owner</td>
                    <td>:</td>
                	<td><?php echo form_dropdown('OWNER',$this->_csv->get_list_owner(),'1','id="OWNER"');?></td>                   </td>
                </tr>
                <tr>
                	<td colspan='2'>&nbsp;</td>
                	<td><input name="download" id="download" type="button" value="Download"></td>
                </tr>
            </table>
            </form>
            <br />
            <div id='report' style="text-align:center">Untuk mendownload data realisasi, silahkan pilih cabang, tahun dan bulan yang dikehendaki</div>
         </div>
	</div>

</div><!-- close div content -->

</td>
</tr>
</table>
<script type="text/javascript">
$(function(){
	$( "#accordion" ).accordion({ active:9});
});	
</script>
<?php $this->load->view('default/footer') ?>