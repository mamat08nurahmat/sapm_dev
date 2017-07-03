<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SAPM - Sales Activity Performance Management New</title>
  <link rel="shortcut icon" href="<?php echo favicon.'favicon.jpg' ?>"><!-- Favicon and touch icons -->

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 --> 
  <link rel="stylesheet" href="<?php echo BOOTSTRAP_NEWCSS ?>bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo FONT_AWESOME_CSS ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo IONIC_CONS_CSS ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo NEWSAPMSTYLE_CSS ?>">
  
  <link rel="stylesheet" href="<?php echo DISK_SKINS_CSS ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo PLUGINS_ICHECK_CSS ?>">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo PLUGINS_MORRIS_CSS ?>">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo PLUGINS_JVECTORMAP_CSS ?>">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo PLUGINS_DATEPICKER_CSS ?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo PLUGINS_DATERANGEPICKER_CSS ?>">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo PLUGINS_BOOTSTRAP_WYSIHTML5_CSS ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
<?php
echo $js_grid;
?>
<script type="text/javascript">

function test(com,grid){
    if (com=='Select All'){
		$('.bDiv tbody tr',grid).addClass('trSelected');
    }
    
    if (com=='DeSelect All'){
		$('.bDiv tbody tr',grid).removeClass('trSelected');
    }
    
    if (com=='Delete'){
	   if($('.trSelected',grid).length>0){
		   if(confirm('Delete ' + $('.trSelected',grid).length + ' items?')){
				var items = $('.trSelected',grid);
				var itemlist ='';
				for(i=0;i<items.length;i++){
					itemlist+= items[i].id.substr(3)+",";
				}
				$.ajax({
				   type: "POST",
				   url: "<?php echo site_url("/countries_feed/deletec");?>",
				   data: "items="+itemlist,
				   success: function(data){
					$('#flex1').flexReload();
					alert(data);
				   }
				});
			}
		} else {
			return false;
		} 
	}          
} 

///Filter for Alphabet Buttons
function filter_alpha(alpha,grid){ 
	//check if letter selected is # for all
	alpha = (alpha == '#')?'%%':alpha;
	var filters = {"groupOp":"AND","rules":[{"field":"name","op":"bw","data":alpha}]};
	filters_value = JSON.stringify(filters);
	$('#flex1').flexOptions({
		newp:1,
		params:[
			{name:'filters', value: filters_value},
			{name:'qtype', value: $('select[name=qtype]').val()}
		]
	});
	
	$('#flex1').flexReload();
} 

///Filter for Alphabet Buttons
function exportTo(format,grid){ 
	var groupOp = $(grid.sDiv).find("select[name=groupOp]").val();
	var squery = '{"groupOp":"' + groupOp + '","rules":[';
	$('.sDiv2').each( function(idx) {
		field = $("select[name=qtype]", this).val();
		op = $("select[name=op]", this).val();
		data = ''
		
		var i = $("select[name=qtype]", this).get(0).selectedIndex;
		
		if (($(".qsbox.q"+i, this).css("display") == "inline") || ($(".qsbox.q"+i, this).css("display") == "inline-block")) {
			data = $(".qsbox.q"+i, this).val();
		}else{
			data = $(".qsbox.default", this).val();
		}

		squery += '{"field":"'+field+'","op":"'+op+'","data":"'+data+'"},';
	});

	squery = squery.substring(squery.length-1,0) + ']}';
	console.dir(squery);
	
	window.location.href = "<?php echo site_url("/countries_feed/export");?>"+"?filters="+squery+"&format="+format;
} 

</script>


<div id="container">
	<h1>Welcome to CodeIgniter with Flexigrid Demo!</h1>

	<div id="body">
	    <table id="flex1" style="display:none"></table>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>
