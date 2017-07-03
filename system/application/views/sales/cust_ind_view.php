<?php $this->load->view('default/header') ?>	

<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});
</script>

<td  valign="top" align="left">

<!--
CIF_KEY
CUST_NAME
COMPANY_NAME
OCCUPATION
PLACE_OF_BIRTH
DATE_OF_BIRTH
SEX_CD
SECRETARY
ADDRESS
MARITAL_CD
CHILDREN
PHONE_1
PHONE_2
EDUCATION
ORGANISATION
IMPORTANT
VACATION
KINSMAN
COST_OF_LIVING
HOBBY
BNI_PRODUCT_CD_1
BNI_PRODUCT_CD_2
BNI_PRODUCT_CD_3
BNI_PRODUCT_CD_4
OTHER_PRODUCT_CD_1
OTHER_PRODUCT_CD_1
NEEDED_PRODUCT
PERSONAL_TRAIT
OTHER_DESCRIPTION
IS_PROSPECT
CUR_BOOK_BAL_IDR
AS_OF_DATE
AVG_BOOK_BAL
BRANCH_CODE
AGE
MACRO
MICRO
PROD_REC
BNI_COMMITMENT_BAL_IDR
BNI_SALES_ID
LAST_ACTIVITY_KEY
LAST_ACTIVITY_DATE
ID 
-->

<div id='content_x'>
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> LEADS MANAGEMENT
    </div>
	<div id="tabs">
        <ul>
            <li><a href="#tabs-1">Leads Kelolaan</a></li>
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
