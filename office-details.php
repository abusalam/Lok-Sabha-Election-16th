<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Office Details</title>
<?php
include('header/header.php');
?>
<?php
$subdiv_cd="0";
if(isset($_SESSION['subdiv_cd']))
	$subdiv_cd=$_SESSION['subdiv_cd'];
?>
<script type="text/javascript" language="javascript">
function fatch_block(str)
{
	<?php
	if(isset($_REQUEST['officeid']))
	{
		?>
		alert("Sub-Division can't be changed while modify");
		bind_all();
		return false;
		<?php
	}
	?>
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  	xmlhttp=new XMLHttpRequest();
	   	xmlhttp1=new XMLHttpRequest();
		xmlhttp2=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	   	xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  /*if (xmlhttp.readyState==1)
	  {
		 document.getElementById("loadingDiv").innerHTML = "<img src='images/loading.gif'/>";
	  }*/
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("Block_result").innerHTML=xmlhttp.responseText;
		}
	  }
	  xmlhttp1.onreadystatechange=function()
	  {
	  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
		{
			document.getElementById("Police_Station").innerHTML=xmlhttp1.responseText;
		}
	  }
	  xmlhttp2.onreadystatechange=function()
	  {
	  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
		{
			document.getElementById("ofcid").innerHTML=xmlhttp2.responseText;
		}
	  }
	xmlhttp.open("GET","ajaxfun.php?subdiv="+str,true);
	xmlhttp1.open("GET","ajaxfun.php?subdiv="+str+"&pol=n",true);
	xmlhttp2.open("GET","ajaxfun.php?subdiv="+str+"&ofcid=n",true);
	xmlhttp.send();
	xmlhttp1.send();
	xmlhttp2.send();
}

function email_valid()
{
	var EmailId = document.getElementById('email').value;
	var emailfilter = /(([a-zA-Z0-9\-?\.?]+)@(([a-zA-Z0-9\-_]+\.)+)([a-z]{2,3}))+$/;
	if((EmailId != "") && (!(emailfilter.test(EmailId ) ) )) {
    //alert("Enter valid email address!");
	document.getElementById('email').style.borderColor="#F00";
	document.getElementById('email').style.backgroundColor="#FCF";
	return false;
	}
}
function count_totalstaff()
{
	var ExistingStaff=document.getElementById("ExistingStaff").value;
	var malestaff=document.getElementById("MaleStaff").value;
	var femalestaff=document.getElementById("FemaleStaff").value;
	if(malestaff=="")
		document.getElementById("MaleStaff").value=0;
	if(femalestaff=="")
		document.getElementById("FemaleStaff").value=0;
	document.getElementById("ExistingStaff").value=(parseInt(document.getElementById("MaleStaff").value,10) + parseInt(document.getElementById("FemaleStaff").value,10));
}
function validate()
{
	var officename=document.getElementById("officename").value;
	var designationOic=document.getElementById("designationOic").value;
	var Street=document.getElementById("Street").value;
	var Town=document.getElementById("Town").value;
	var PostOffice=document.getElementById("PostOffice").value;
	var Subdivision=document.getElementById("Subdivision").value;
	var PoliceStation=document.getElementById("PoliceStation").value;
	var Municipality=document.getElementById("Municipality").value;
	var District=document.getElementById("District").value;
	var Pincode=document.getElementById("Pincode").value;
	var Statusofoffice=document.getElementById("Statusofoffice").value;
	var Natureofoffice=document.getElementById("Natureofoffice").value;
	var Mb_no=document.getElementById("Mb_no").value;
	var ExistingStaff=document.getElementById("ExistingStaff").value;

	var malestaff=document.getElementById("MaleStaff").value;
	var femalestaff=document.getElementById("FemaleStaff").value;

	if(officename=="")
	{
		document.getElementById("msg").innerHTML="Enter Name Of Office";
		document.getElementById("officename").focus();
		return false;
	}
	if(designationOic=="")
	{
		document.getElementById("msg").innerHTML="Enter Designation of office-in-charge";
		document.getElementById("designationOic").focus();
		return false;
	}
	if(Street=="")
	{
		document.getElementById("msg").innerHTML="Enter the name of Para/Tola/Street";
		document.getElementById("Street").focus();
		return false;
	}
	if(Town=="")
	{
		document.getElementById("msg").innerHTML="Enter the name of Vill/Town/Metro";
		document.getElementById("Town").focus();
		return false;
	}
	if(PostOffice=="")
	{
		document.getElementById("msg").innerHTML="Enter the name of Post Ofice";
		document.getElementById("PostOffice").focus();
		return false;
	}

	if(Subdivision=="0")
	{
		document.getElementById("msg").innerHTML="Select Subdivision name";
		document.getElementById("Subdivision").focus();
		return false;
	}
	if(PoliceStation=="0")
	{
		document.getElementById("msg").innerHTML="Select Police Station name";
		document.getElementById("PoliceStation").focus();
		return false;
	}
	if(Municipality=="0")
	{
		document.getElementById("msg").innerHTML="Select Municipality name";
		document.getElementById("Municipality").focus();
		return false;
	}
	if(District=="")
	{
		document.getElementById("msg").innerHTML="Enter the name of District";
		document.getElementById("District").focus();
		return false;
	}
	if(Pincode=="")
	{
		document.getElementById("msg").innerHTML="Enter the Pin Code";
		document.getElementById("Pincode").focus();
		return false;
	}
	if(Pincode.length<6)
	{
		document.getElementById("msg").innerHTML="Check the Pin Code";
		document.getElementById("Pincode").focus();
		return false;
	}
	if(Statusofoffice=="0")
	{
		document.getElementById("msg").innerHTML="Select the Status of office";
		document.getElementById("Statusofoffice").focus();
		return false;
	}
	if(Natureofoffice=="0")
	{
		document.getElementById("msg").innerHTML="Select Nature of office";
		document.getElementById("Natureofoffice").focus();
		return false;
	}

	var EmailId = document.getElementById('email').value;
	var emailfilter = /(([a-zA-Z0-9\-?\.?]+)@(([a-zA-Z0-9\-_]+\.)+)([a-z]{2,3}))+$/;
	if((EmailId != "") && (!(emailfilter.test(EmailId ) ) )) {
    document.getElementById("msg").innerHTML="Enter valid email address";
	document.getElementById("msg").focus();
	return false;
	}

	if(Mb_no=="")
	{
		document.getElementById("msg").innerHTML="Enter Mobile No";
		document.getElementById("Mb_no").focus();
		return false;
	}
	if(ExistingStaff=="")
	{
		document.getElementById("msg").innerHTML="Enter Number of Existing Staff";
		document.getElementById("ExistingStaff").focus();
		return false;
	}
	if(malestaff!="0" || femalestaff!="0")
	{
		if((+malestaff + +femalestaff)!=ExistingStaff)
		{
			document.getElementById("msg").innerHTML="Male, Female & Total Existing Staff No not matching";
			document.getElementById("ExistingStaff").focus();
			return false;
		}
	}
}
</script>

<script language="JavaScript" src="js/gen_validatorv4.js"
    type="text/javascript" xml:space="preserve"></script>
</head>
<?php
include_once('inc/db_trans.inc.php');
$action=$_REQUEST['submit'];
if($action=='Save')
{
	$officename=clean_spl($_POST['officename']);
	$designationOic=$_POST['designationOic'];
	$Street=clean_spl($_POST['Street']);
	$Town=clean_spl($_POST['Town']);
	$PostOffice=clean_spl($_POST['PostOffice']);
	$Subdivision=$_POST['Subdivision'];
	$PoliceStation=$_POST['PoliceStation'];
	$Municipality=$_POST['Municipality'];
	$Pincode=only_num($_POST['Pincode']);
	$Statusofoffice=$_POST['Statusofoffice'];
	$Natureofoffice=$_POST['Natureofoffice'];
	$email=$_POST['email'];
	$Ph_no=clean_alpha($_POST['Ph_no']);
	$Mb_no=clean_alpha($_POST['Mb_no']);
	$FAX_no=clean_alpha($_POST['FAX_no']);
	$MaleStaff=only_num($_POST['MaleStaff']);
	$FemaleStaff=only_num($_POST['FemaleStaff']);
	$ExistingStaff=only_num($_POST['ExistingStaff']);
	$OfficeID=$_POST['OfficeID'];

	$dist_code=$dist_cd;
	$usercd=$user_cd;
	if($Subdivision==$subdiv_cd)
	{
		include_once('function/add_fun.php');
		$ret;
		if(isset($_REQUEST['officeid']))
		{
			$dt = new DateTime();
			$posted_date=$dt->format('Y-m-d H:i:s');
			$ret=update_officedetails($OfficeID,$designationOic,$officename,$Street,$Town,$PostOffice,$Pincode,$Municipality,$PoliceStation,$Statusofoffice,$email,$Ph_no,$Mb_no,$FAX_no,$ExistingStaff,$MaleStaff,$FemaleStaff,$Subdivision,$dist_code,$Natureofoffice,$usercd,$posted_date);
			if($ret==1)
			{
				?> <script>location.replace("office-details.php?msg=success");</script> <?php
			}
		}
		else
		{
			$ret=save_officedetails($OfficeID,$designationOic,$officename,$Street,$Town,$PostOffice,$Pincode,$Municipality,	$PoliceStation,$Statusofoffice,$email,$Ph_no,$Mb_no,$FAX_no,$ExistingStaff,$MaleStaff,$FemaleStaff,$Subdivision,$dist_code,$Natureofoffice,$usercd);
		}
		if($ret==1)
		{
			$msg="<div class='alert-success'>Record saved successfully</div>";
		}
		unset($ret);
	}
	else
	{
		$msg="<div class='alert-error'>Office details entry of subdivision you selected not allowed</div>";
	}
     // prevent form from actually posting (only for demo purposes)
/*	echo "\nSubDiv: ".$Subdivision."\n";
	echo "Municipality: ".$Municipality."\n";
	echo "PoliceStation: ".$PoliceStation."\n";
	echo "OfficeID: ".$OfficeID."\n";*/
}
?>

<?php
if(isset($_REQUEST['officeid']))
{
	$offccd=decode($_REQUEST['officeid']);

	$rsOffice=fatch_offcDtl($offccd);
	$rowOffice=getRows($rsOffice);
}
if(isset($_REQUEST['msg']))
{
	if($_REQUEST['msg']=='success')
	{
		$msg="<div class='alert-success'>Record updated successfully</div>";
	}
}
?>
<script language="javascript" type="text/javascript">
function bind_all()
{
<?php	if(! isset($offccd))
	{	?>
		var subdivision=document.getElementById('Subdivision');
		for (var i = 0; i < subdivision.options.length; i++) 
		{
			if (subdivision.options[i].value == "<?php echo $subdiv_cd; ?>")
			{
				subdivision.options[i].selected = true;
			}
		}
		fatch_block(subdivision.value);
<?php } ?>
	var officename=document.getElementById('officename');
	officename.value="<?php echo $rowOffice['office']; ?>";
	var designationOic=document.getElementById('designationOic');
	designationOic.value="<?php echo $rowOffice['officer_desg']; ?>";
	var Street=document.getElementById('Street');
	Street.value="<?php echo $rowOffice['address1']; ?>";
	var Town=document.getElementById('Town');
	Town.value="<?php echo $rowOffice['address2']; ?>";
	var PostOffice=document.getElementById('PostOffice');
	PostOffice.value="<?php echo $rowOffice['postoffice']; ?>";
	var subdiv = document.getElementById('Subdivision');
	for (var i = 0; i < subdiv.options.length; i++) 
	{
		if (subdiv.options[i].value == "<?php echo $rowOffice['subdivisioncd']; ?>")
		{
			subdiv.options[i].selected = true;
		}
    }
	subdiv.readOnly=true;
	var policestn = document.getElementById('PoliceStation');
	for (var i = 0; i < policestn.options.length; i++) 
	{
		if (policestn.options[i].value == "<?php echo $rowOffice['policestn_cd']; ?>")
		{
			policestn.options[i].selected = true;
		}
    }
	var Municipality = document.getElementById('Municipality');
	for (var i = 0; i < Municipality.options.length; i++) 
	{
		if (Municipality.options[i].value == "<?php echo $rowOffice['blockormuni_cd']; ?>")
		{
			Municipality.options[i].selected = true;
		}
    }
	var Pincode=document.getElementById('Pincode');
	Pincode.value="<?php echo $rowOffice['pin']; ?>";
	var Statusofoffice=document.getElementById('Statusofoffice');
	for (var i = 0; i < Statusofoffice.options.length; i++) 
	{
		if (Statusofoffice.options[i].value == "<?php echo $rowOffice['govt']; ?>")
		{
			Statusofoffice.options[i].selected = true;
		}
    }
	var Natureofoffice=document.getElementById('Natureofoffice');
	for (var i = 0; i < Natureofoffice.options.length; i++) 
	{
		if (Natureofoffice.options[i].value == "<?php echo $rowOffice['institutecd']; ?>")
		{
			Natureofoffice.options[i].selected = true;
		}
    }
	var email=document.getElementById('email');
	email.value="<?php echo $rowOffice['email']; ?>";
	var Ph_no=document.getElementById('Ph_no');
	Ph_no.value="<?php echo $rowOffice['phone']; ?>";
	var Mb_no=document.getElementById('Mb_no');
	Mb_no.value="<?php echo $rowOffice['mobile']; ?>";
	var FAX_No=document.getElementById('FAX_No');
	FAX_No.value="<?php echo $rowOffice['fax']; ?>";
	var MaleStaff=document.getElementById('MaleStaff');
	MaleStaff.value="<?php echo $rowOffice['male_staff']; ?>";
	var FemaleStaff=document.getElementById('FemaleStaff');
	FemaleStaff.value="<?php echo $rowOffice['female_staff']; ?>";
	var ExistingStaff=document.getElementById('ExistingStaff');
	ExistingStaff.value="<?php echo $rowOffice['tot_staff']; ?>";
	var OfficeID=document.getElementById('OfficeID');
	OfficeID.value="<?php echo $rowOffice['officecd']; ?>";
	OfficeID.readOnly=true;
}
</script>
<body oncontextmenu="return false;" onload="javascript: bind_all();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2"><?php print $environment; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center"><?php echo $_SESSION[subdiv_name]; ?> SUBDIVISION</td></tr>
<tr><td align="center">OFFICE DETAILS ENTRY</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
  <table width="95%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" colspan="4" align="center"><?php print $msg; ?><span id="msg" class="error"></span></td>
    </tr>
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Name of Office</td>
      <td align="left"><input type="text" name="officename" id="officename" style="width:250px;"  /></td>
      <td align="left" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Designation of office-in-charge</td>
      <td align="left"><input type="text" name="designationOic" id="designationOic" style="width:250px;"/></td>
    </tr>
    <tr><td colspan="2" align="left"><b>Office Address</b></td></tr>
    <tr>
      <td align="left"><span class="error">*</span>Para/Tola/Street</td>
      <td align="left"><input type="text" name="Street" id="Street" maxlength="50" style="width:250px;" /><br />
      								</td>
      <td align="left"><span class="error">*</span>Vill/Town/Metro</td>
      <td align="left"><input type="text" name="Town" id="Town" maxlength="50" style="width:142px;" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Post Office</td>
      <td align="left"><input type="text" name="PostOffice" id="PostOffice" maxlength="50" style="width:142px;" /><br />
      								</td>
                                    <td align="left"><span class="error">*</span>Subdivision</td>
      <td align="left"> <select name="Subdivision" id="Subdivision" style="width:150px;" onchange="fatch_block(this.value)" >
      <option value="0">-Select Subdivision-</option>
                            <?php 	$districtcd=$dist_cd;
									$rsBn=fatch_Subdivision($districtcd);
									$num_rows=rowCount($rsBn);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowBn=getRows($rsBn);
											echo "<option value='$rowBn[0]'>$rowBn[2]</option>";
										}
									}
									$rsBn=null;
									$num_rows=0;
									$rowBn=null;
									$districtcd=0;
							?>
      </select></td>
    </tr>
     <tr>
      <td align="left"><span class="error">*</span>Police Station</td>
      <td align="left"><span id='Police_Station'><select name="PoliceStation" id="PoliceStation" style="width:150px;">
      <?php
	  	if(isset($offccd))
		{
			$rspol=fatch_PoliceStation($rowOffice['subdivisioncd']);
			$num_rows = rowCount($rspol);
			if($num_rows>0)
			{
				echo "<option value='0'>-Select Police Station-</option>\n";
				for($i=1;$i<=$num_rows;$i++)
				{
				  $rowpol=getRows($rspol);
				  echo "<option value='$rowpol[0]'>$rowpol[2]</option>\n";
				}
			}
			$rspol=null;
			$rowpol=null;
		}
	  ?>
      </select> </span> <br />
      								</td>
                                    <td align="left"><span class="error">*</span>Block/Municipality</td>
      <td align="left"> <span id='Block_result'><select name="Municipality" id="Municipality" style="width:150px;">
      <?php
	  	if(isset($offccd))
		{
			$rsblock=fatch_block($rowOffice['subdivisioncd']);
			$num_rows = rowCount($rsblock);
			if($num_rows>0)
			{
				echo "<option value='0'>-Select Block/Municipality-</option>\n";
				for($i=1;$i<=$num_rows;$i++)
				{
				  $rowblock=getRows($rsblock);
				  echo "<option value='$rowblock[0]'>$rowblock[2]</option>\n";
				}
			}
			$rspol=null;
			$rowpol=null;
		}
	  ?>
      </select></span> </td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>District</td>
      <td align="left"><input type="text" name="District" id="District" maxlength="50" style="width:142px;" value="<?php print $district; ?>" readonly="readonly" /><br />
      								</td>
                                    <td align="left"><span class="error">*</span>Pin Code</td>
      <td align="left"><input type="text" name="Pincode" id="Pincode" maxlength="6" style="width:142px;" onkeypress="javascript:return wholenumbersonly(event);" /></td>
    </tr>

    <tr>
      <td align="left"><span class="error">*</span>Status of Office</td>
      <td align="left"><select name="Statusofoffice" id="Statusofoffice" style="width:150px;">
      <option value="0">-Select Status of Office-</option>
                            <?php 	$rsBn=fatch_statusofoffice('');
									$num_rows=rowCount($rsBn);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowBn=getRows($rsBn);
											echo "<option value='$rowBn[0]'>$rowBn[1]</option>\n";
										}
									}
									$rsBn=null;
									$num_rows=0;
									$rowBn=null;
							?>

      </select><br /></td>
                                    <td align="left"><span class="error">*</span>Nature of Office</td>
      <td align="left"><select name="Natureofoffice" id="Natureofoffice" style="width:150px;">
      <option value="0">-Select Nature of office-</option>
                            <?php 	$rsBn=fatch_Natureofoffice();
									$num_rows=rowCount($rsBn);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowBn=getRows($rsBn);
											echo "<option value='$rowBn[0]'>$rowBn[1]</option>\n";
										}
									}
									$rsBn=null;
									$num_rows=0;
									$rowBn=null;
							?>

      </select></td>
    </tr>
      <tr><td colspan="2" align="left"><b>Contact Number</b></td></tr>
    <tr>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>Email ID</td>
      <td align="left"><input type="text" name="email" id="email" style="width:142px;" onblur="return email_valid();" maxlength="30"  />
        &nbsp;&nbsp; <span class="error">&nbsp;&nbsp;</span>Phone No</td>
      <td align="left"><input type="text" name="Ph_no" id="Ph_no" style="width:100px;" onkeypress="javascript:return wholenumbersonly(event);" maxlength="14" />
        &nbsp;&nbsp; <span class="error">*</span>Mobile No</td>
      <td align="left"><input type="text" name="Mb_no" id="Mb_no" style="width:142px;" onkeypress="javascript:return wholenumbersonly(event);" maxlength="12" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>FAX No</td>
      <td align="left"><input type="text" name="FAX_No" id="FAX_No" maxlength="50" style="width:142px;"  /></td>

    </tr>

    <tr>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>Total Male Staff</td>
      <td align="left"><input type="text" name="MaleStaff" id="MaleStaff" style="width:50px;" maxlength="3" onkeypress="javascript:return wholenumbersonly(event);" onblur="return count_totalstaff();" value="0" />&nbsp;&nbsp; <span class="error">&nbsp;&nbsp;</span>Total Female Staff</td>
      <td align="left"><input type="text" name="FemaleStaff" id="FemaleStaff" style="width:50px;" maxlength="3" onkeypress="javascript:return wholenumbersonly(event);" onblur="return count_totalstaff();" value="0" />&nbsp;&nbsp; <span class="error">*</span>Total Existing Number of Staff</td>
      <td align="left"><input type="text" name="ExistingStaff" id="ExistingStaff" style="width:142px;" maxlength="3" onkeypress="javascript:return wholenumbersonly(event);" /></td>
    </tr>
	<tr><td align="left"><span class="error">&nbsp;&nbsp;</span>Office ID</td><td align="left"><span id="ofcid"><input type="text" name="OfficeID" id="OfficeID" style="width:142px;" /></span></td><td colspan="2">&nbsp;</td></tr>
    <tr>
      <td colspan="4" align="center"><input type="submit" name="submit" id="submit" value="Save" class="button" onclick="javascript:return validate();" /></td>
    </tr>
    <tr><td></td><td colspan="3" align="left"><div id="form1_errorloc" class="error"></div></td></tr>
  </table>
</form>
</td></tr></table>
</td></tr>
</table>
</div>
<script language="JavaScript" type="text/javascript"
    xml:space="preserve">//<![CDATA[
  //You should create the validator only after the definition of the HTML form
  var frmvalidator  = new Validator("form1");
  frmvalidator.EnableOnPageErrorDisplaySingleBox();
  frmvalidator.EnableMsgsTogether();
 
  frmvalidator.addValidation("officename","req","Office name required");
  //frmvalidator.addValidation("officename","maxlen=20",	"Max length for FirstName is 20");
  //frmvalidator.addValidation("FirstName","alpha_s","Name can contain alphabetic chars only");
  
  //frmvalidator.addValidation("designationOic","req","Please enter your Last Name");
  frmvalidator.addValidation("designationOic","dontselect=0000");
  //frmvalidator.addValidation("LastName","maxlen=20","For LastName, Max length is 20");
  
  frmvalidator.addValidation("Street","req","Street name required");
  
  frmvalidator.addValidation("Town","req","Town required");
  frmvalidator.addValidation("PostOffice","req","Post Office required");
  /*
  frmvalidator.addValidation("Email","email");
  
  frmvalidator.addValidation("Phone","maxlen=50");
  frmvalidator.addValidation("Phone","numeric");
  
  frmvalidator.addValidation("Address","maxlen=50");
  frmvalidator.addValidation("Country","dontselect=00");*/
  
//]]></script>
</body>
</html>