<?php
session_start();
extract($_GET);
include_once('../inc/db_trans.inc.php');
include_once('../function/3rd_rando_fun.php');
if(isset($_SESSION['subdiv_cd']))
	$subdiv_cd=$_SESSION['subdiv_cd'];
else
	$subdiv_cd="0";
$opn=isset($_GET["opn"])?$_GET["opn"]:"";
if($opn=='rando_asm')
{
	$rsasm= fatch_assembly_party_3rdrando_details($subdiv_cd);
	$num_rows = rowCount($rsasm);
	//echo "<input type=''"
	if($num_rows<1)
	{
		echo "No record found";
	}
	else
	{
		echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1' >\n";
		echo "<tr height='30px'><th><input type='checkbox' id='chk_all'/></th><th>Assembly</th>
				</tr>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
		  $rowasm=getRows($rsasm);
		  echo "<tr height='25px'>";
	      echo "<td align='center' width='14%'><input type='checkbox' name='check_$i' id='check_$i' value='$rowasm[assemblycd]'  class='chk_asm' ";
		 // if($rowasm['rand_status']=='Y')
		 //   echo "checked";
		//  else
		    echo "";
		  echo "/></td>"; 
		  echo "<td width='86%' align='left' style='padding-left:5px;'>";
		  if($rowasm['rand_status']=='Y')
		    echo "<span style='color: green;'>$rowasm[assemblyname]</span> <img src='images/s_success.png' height='15px' style='vertical-align:middle; padding-bottom: 2px;'/>";
		  else
		    echo "<span style='color:red;'>$rowasm[assemblyname]</span> ";
		  echo "</td>";
		  echo "</tr>";
		}
		echo "</table>";
	}
}

?>
<script type="text/javascript">  
$(document).ready(function(){
						   //window.load();			
	$('#chk_all').click(function() {  //on click 
        if(this.checked) { // check select status
            $('.chk_asm').each(function() { //loop through each checkbox
                this.checked = true;  /*select all checkboxes with class "checkbox1"*/               // selected_chk.push($(this).attr('value'));	
            });
        }else{
            $('.chk_asm').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
});
</script>