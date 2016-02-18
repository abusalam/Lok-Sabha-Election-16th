
<script src="../css/cal/js/jquery.min.js"></script>
<script src="../css/cal/js/kendo.web.min.js"></script>



<?php
$subdiv=(isset($_REQUEST['subdiv'])?$_REQUEST['subdiv']:'0');

?>
<div id="load_result"></div>

<script type="text/javascript">
$(function(){
 
	data="subdiv=<?php echo $subdiv;?>";
	document.getElementById("load_result").innerHTML="<img src='../images/loading1.gif' alt='' height='150px' width='250px' />";
	$.ajax({
		type:"get",
		url: "first_app3_excel.php",
		cache: false,
		data: data,
		success: function(data1) {
			//alert(data1.length);
			if(data1.length>10)
			{
				document.getElementById("load_result").innerHTML="<?php $filename = "first_appt.xls"; // File Name
		// Download file
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: application/vnd.ms-excel");?>";
				$("#load_result").html(data1);
			}
		}
	});

});
</script>
