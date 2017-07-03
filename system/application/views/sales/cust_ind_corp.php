<?php $this->load->view('default/header') ?>	

<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});
</script>

<td  valign="top" align="left">



<div id='content_x'>
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> SALES CUSTOMER MANAGEMENT
    </div>
	<div id="tabs">
        <ul>
            <li><a href="#tabs-1">Customer Corporate</a></li>
        </ul>
        <div id="tabs-1">
            <table width="100%" border="0" cellspacing="0">
              
                <?php 
                    #print_r($data);
                    if(isset($data) && $data)
                    {	
                        $n = 1;
                        foreach($data[0] as $row => $val){
                            $color = (($n%2) == 0)?'#ffffff':'#eeeeee';
                ?>
                      <tr bgcolor="<?php echo $color ?>">
                        <td><div style="padding:2px"><?php echo str_replace("_"," ",$row) ?></div></td><td>:</td><td><div style="padding:2px"><?php echo $val ?></div></td>
                      </tr>
                 <?php $n++; }} ?>
            </table>
		</div>
    </div>
</div>
	<div align="center"><input name="Back" type="button" value="Back" onclick="history.back()" /></div>
</td>
</tr>
</table>	
<script type="text/javascript">
$(function(){
	$( "#accordion" ).accordion({ active:3 });
});
</script>

<?php $this->load->view('default/footer') ?>