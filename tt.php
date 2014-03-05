<?php
$con=mysql_connect("127.0.0.1","root","root") or die();
$db=mysql_select_db("ppds",$con) or die();
		$rResult = mysql_query("select name,phone_no,message from tblsms") or die();
		$count = mysql_num_fields($rResult);
		
		$html = '<table border="1"><thead><tr>%s</tr><thead><tbody>%s</tbody></table>';
		$thead = '';
		$tbody = '';
		$line = '<tr>%s</tr>';
		for ($i = 0; $i < $count; $i++){      
		  $thead .= sprintf('<th>%s</th>',mysql_field_name($rResult, $i));
		}
		//== for defined table ==
		 $thead="<th>Name</th><th>Phone No</th><th>Message</th>";
		while(false !== ($row = mysql_fetch_row($rResult))){
		  $trow = '';
		
		  foreach($row as $value){
		   $trow .= sprintf('<td>%s</td>', $value);
		  }
		
		  $tbody .= sprintf($line, $trow);
		
		}
mysql_close($con);		
		
		header("Content-type: application/vnd.ms-excel; name='excel'");
		header("Content-Disposition: attachment; filename=exportfile.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		print sprintf($html, $thead, $tbody);
		exit;
?>