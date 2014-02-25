<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Employee Details</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function fatch_offcdtl(str)
{
	<?php
	if(isset($_REQUEST['personcd']))
	{
		?>
		alert("Office can't be changed while modify");
		bind_all();
		return false;
		<?php
	}
	?>
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  xmlhttp1=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("ofc_details").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajaxfun.php?offccd="+str,true);
	//xmlhttp1.open("GET","ajaxfun.php?offccd="+str+"&personid=n",true);
	xmlhttp.send();
	//xmlhttp1.send();
}
function fatch_branch(str,distc)
{
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  /*if (xmlhttp.readyState==1)
	  {
		 document.getElementById("loadingDiv").innerHTML = "<img src='images/loading.gif'/>";
	  }*/
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("branch_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajaxfun.php?bank="+str+"&dist="+distc,true);
	xmlhttp.send();
}
	
function chkset_change()
{
	var preadd1=document.getElementById('preaddress1').value;
	var preadd2=document.getElementById('preaddress2').value;
	var chkset=document.getElementById('chkset');
	if(chkset.checked==true)
	{
		document.getElementById('peraddress1').value=preadd1;
		document.getElementById('peraddress1').readOnly=true;
		document.getElementById('peraddress2').value=preadd2;
		document.getElementById('peraddress2').readOnly=true;
	}
	else
	{
		document.getElementById('peraddress1').value="";
		document.getElementById('peraddress1').disabled=false;
		document.getElementById('peraddress2').value="";
		document.getElementById('peraddress2').disabled=false;
	}
}
function email_valid()
{
	var EmailId = document.getElementById('email').value;
	var emailfilter = /(([a-zA-Z0-9\-?\.?]+)@(([a-zA-Z0-9\-_]+\.)+)([a-z]{2,3}))+$/;
	if((EmailId != "") && (!(emailfilter.test(EmailId ) ) )) {
    alert("Enter valid email address!");
	return false;
	}
}
function validate()
{
	var offcode=document.getElementById("offcode").value;
	var empname=document.getElementById("empname").value;
	var designation=document.getElementById("designation").value;
	var dob=document.getElementById("dob").value;
	var sex=document.getElementById("sex").value;
	var scale=document.getElementById("scale").value;
	var basicpay=document.getElementById("basicpay").value;
	var gradepay=document.getElementById("gradepay").value;
	var preaddress1=document.getElementById("preaddress1").value;
	var peraddress1=document.getElementById("peraddress1").value;
	var r_no=document.getElementById("r_no").value;
	var m_no=document.getElementById("m_no").value;
	var qualification=document.getElementById("qualification").value;
	var language=document.getElementById("language").value;
	var bank=document.getElementById("bank").value;
	var branch=document.getElementById("branch").value;
	var acc_no=document.getElementById("acc_no").value;
	var voterof=document.getElementById("voterof").value;
	var partno=document.getElementById("partno").value;
	var sl_no=document.getElementById("sl_no").value;
	var epic_no=document.getElementById("epic_no").value;
	var ac_pre=document.getElementById("ac_pre").value;
	var ac_per=document.getElementById("ac_per").value;
	var ac_posting=document.getElementById("ac_posting").value;
	var posting_status=document.getElementById("posting_status").value;
	var remarks=document.getElementById("remarks").value;
	var file=document.getElementById("file");
	if(file.value!="")
	{
		var attachment;
		attachment = file.files[0];
		if(attachment.size<10240 || attachment.size>30720)
		{
			document.getElementById("msg").innerHTML="Unaccepted file size. Please try again";
			return false;
		}
	}
	if(offcode=="0")
	{
		document.getElementById("msg").innerHTML="Select Office Code";
		document.getElementById("offcode").focus();
		return false;
	}
	if(empname=="")
	{
		document.getElementById("msg").innerHTML="Enter Employee Name";
		document.getElementById("empname").focus();
		return false;
	}
	if(designation=="0")
	{
		document.getElementById("msg").innerHTML="Select Designation";
		document.getElementById("designation").focus();
		return false;
	}
	if(dob=="")
	{
		document.getElementById("msg").innerHTML="Enter Date of Birth";
		document.getElementById("dob").focus();
		return false;
	}
	if(sex=="0")
	{
		document.getElementById("msg").innerHTML="Select Sex";
		document.getElementById("sex").focus();
		return false;
	}
	/*if(scale=="")
	{
		document.getElementById("msg").innerHTML="Enter Scale of Pay";
		document.getElementById("scale").focus();
		return false;
	}*/
	if(basicpay=="")
	{
		document.getElementById("msg").innerHTML="Enter Basic Pay";
		document.getElementById("basicpay").focus();
		return false;
	}
	if(gradepay=="")
	{
		document.getElementById("msg").innerHTML="Enter Grade Pay";
		document.getElementById("gradepay").focus();
		return false;
	}
	if(preaddress1=="")
	{
		document.getElementById("msg").innerHTML="Enter Present Address";
		document.getElementById("preaddress1").focus();
		return false;
	}
	if(peraddress1=="")
	{
		document.getElementById("msg").innerHTML="Enter Permanent Address";
		document.getElementById("peraddress1").focus();
		return false;
	}
	
	var EmailId = document.getElementById('email').value;
	var emailfilter = /(([a-zA-Z0-9\-?\.?]+)@(([a-zA-Z0-9\-_]+\.)+)([a-z]{2,3}))+$/;
	if((EmailId != "") && (!(emailfilter.test(EmailId ) ) )) {
    alert("Enter valid email address!");
	return false;
	}
	
	/*if(r_no=="")
	{
		document.getElementById("msg").innerHTML="Enter Residence Ph No";
		document.getElementById("r_no").focus();
		return false;
	}*/
	if(m_no=="")
	{
		document.getElementById("msg").innerHTML="Enter Mobile No";
		document.getElementById("m_no").focus();
		return false;
	}
	if(qualification=="0")
	{
		document.getElementById("msg").innerHTML="Select Qualification";
		document.getElementById("qualification").focus();
		return false;
	}
	if(language=="0")
	{
		document.getElementById("msg").innerHTML="Select Language";
		document.getElementById("language").focus();
		return false;
	}
	/*if(bank=="")
	{
		document.getElementById("msg").innerHTML="Select Bank Name";
		document.getElementById("bank").focus();
		return false;
	}
	if(branch=="")
	{
		document.getElementById("msg").innerHTML="Select Branch Name";
		document.getElementById("branch").focus();
		return false;
	}
	if(acc_no=="")
	{
		document.getElementById("msg").innerHTML="Enter A/c No";
		document.getElementById("acc_no").focus();
		return false;
	}*/
	if(voterof=="")
	{
		document.getElementById("msg").innerHTML="Enter Voter of Assembly";
		document.getElementById("voterof").focus();
		return false;
	}
	if(partno=="")
	{
		document.getElementById("msg").innerHTML="Enter Part No";
		document.getElementById("partno").focus();
		return false;
	}
	if(sl_no=="")
	{
		document.getElementById("msg").innerHTML="Enter Serial No";
		document.getElementById("sl_no").focus();
		return false;
	}
	if(epic_no=="")
	{
		document.getElementById("msg").innerHTML="Enter EPIC No";
		document.getElementById("epic_no").focus();
		return false;
	}
	if(ac_pre=="0")
	{
		document.getElementById("msg").innerHTML="Select Present Assembly";
		document.getElementById("ac_pre").focus();
		return false;
	}
	if(ac_per=="0")
	{
		document.getElementById("msg").innerHTML="Select Permanent Assembly";
		document.getElementById("ac_per").focus();
		return false;
	}
	if(ac_posting=="0")
	{
		document.getElementById("msg").innerHTML="Select Posting Assembly";
		document.getElementById("ac_posting").focus();
		return false;
	}
	if(posting_status=="0")
	{
		document.getElementById("msg").innerHTML="Select Posting Status";
		document.getElementById("posting_status").focus();
		return false;
	}
	if(remarks=="")
	{
		document.getElementById("msg").innerHTML="Enter Remarks";
		document.getElementById("remarks").focus();
		return false;
	}
	/*if(file.value=="")
	{
		document.getElementById("msg").innerHTML="Select picture";
		document.getElementById("file").focus();
		return false;
	}*/
	
}

function validateFileExtension(Source, args)
{
	var fuData = document.getElementById('file');
	var FileUploadPath = fuData.value;
	if (FileUploadPath == '') {
		// There is no file selected 
		args.IsValid = false;
	}
	else {
		var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
		if (Extension == "jpg" || Extension == "jpeg" || Extension == "png") {
			//args.IsValid = true; // Valid file type
			//FileUploadPath == '';
			return true;
		}
		else {
			alert("'."+Extension+"' extention is not accepted"); // Not valid file type
			document.getElementById('file').value="";
			return false;
		}
	}
}
</script>
</head>
<?php
include_once('inc/db_trans_for_police.inc.php');
$action=$_REQUEST['submit'];
if($action=='Save')
{
	$offcode=$_POST['offcode'];
	$empname=clean_spl($_POST['empname']);
	$designation=$_POST['designation'];
	$dob=$_POST['dob'];
	$sex=$_POST['sex'];
	$scale=clean_alpha($_POST['scale']);
	$basicpay=only_num($_POST['basicpay']);
	$gradepay=only_num($_POST['gradepay']);
	$preaddress1=clean_spl($_POST['preaddress1']);
	$preaddress2=clean_spl($_POST['preaddress2']);
	$peraddress1=clean_spl($_POST['peraddress1']);
	$peraddress2=clean_spl($_POST['peraddress2']);
	$workingstatus=$_POST['workingstatus'];
	$email=$_POST['email'];
	$r_no=clean_alpha($_POST['r_no']);
	$m_no=clean_alpha($_POST['m_no']);
	$qualification=$_POST['qualification'];
	$language=$_POST['language'];
	$bank=$_POST['bank'];
	$branch=$_POST['branch'];
	$acc_no=clean_alpha($_POST['acc_no']);
	$voterof=$_POST['voterof'];
	$partno=$_POST['partno'];
	$sl_no=$_POST['sl_no'];
	$epic_no=$_POST['epic_no'];
	$ac_pre=$_POST['ac_pre'];
	$ac_per=$_POST['ac_per'];
	$ac_posting=$_POST['ac_posting'];
	
	$posting_status=$_POST['posting_status'];
	$remarks=clean_spl($_POST['remarks']);
	$group=$_POST['group'];

	$upload_file="";
	if (empty($_FILES['file']['name']))
	{
		$upload_file=$_POST['hid_file'];
	}
	else
	{
		if((($_FILES['file']['size'] >= 10240)
		&& ($_FILES['file']['size'] <= 30720)))
		{
			if($_FILES['file']['error'] > 0){
				echo "Error ".$_FILES['file']['error'];
				exit();
			}
			else{
				$file_name = $_FILES['file']['name'];
				$random_digit = rand(0, 999999999);
				$new_file_name = $random_digit."_".$file_name;
				move_uploaded_file($_FILES['file']['tmp_name'], "employee_photo/" . $new_file_name);
				//$upload_path1 = "profile_photo/".$new_file_name;
				$upload_file = $new_file_name;
			}
		}
	}
	$dist_code=$dist_cd;
	$subdiv_cd="0";
	if(isset($_SESSION['subdiv_cd']))
		$subdiv_cd=$_SESSION['subdiv_cd'];
	$p_id=$_POST['hid_personnel_code'];
	//=============== Getting Person ID ==================
	if($p_id=='')
	{
		$rsmaxcode=fatch_personnel_maxcode($subdiv_cd);
		$rowmaxcode=getRows($rsmaxcode);
		if($rowmaxcode[0]==null)
			$p_id=$subdiv_cd."00001";
		else
			$p_id=$rowmaxcode[0]+1;
	}
	
		
	$usercd=$user_cd;
	include_once('function/add_police_fun.php');
	if(isset($_REQUEST['personcd']))
	{
		//$tr_cd=decode($_REQUEST['personcd']);
		$dt = new DateTime();
		$posted_date=$dt->format('Y-m-d H:i:s');
		//$ret=update_training_type($training_code,$training_desc,$usercd,$posted_date);
		$ret=update_personnel($p_id,$offcode,$empname,$designation,$preaddress1,$preaddress2,$peraddress1,$peraddress2,$workingstatus,$dob,$sex,$scale,$basicpay,$gradepay,$email,$r_no,$m_no,$qualification,$language,$epic_no,$sl_no,$partno,$posting_status,$ac_pre,$ac_posting,$ac_per,$voterof,$acc_no,$bank,$branch,$remarks,$group,$upload_file,$usercd,$posted_date);
	}
	else
	{
		$ret=save_personnel($p_id,$offcode,$empname,$designation,$preaddress1,$preaddress2,$peraddress1,$peraddress2,$workingstatus,$dob,$sex,$scale,$basicpay,$gradepay,$email,$r_no,$m_no,$qualification,$language,$epic_no,$sl_no,$partno,$posting_status,$ac_pre,$ac_posting,$ac_per,$voterof,$dist_code,$subdiv_cd,$acc_no,$bank,$branch,$remarks,$group,$upload_file,$usercd);
	}
	if($ret==1)
	{
		$msg="<div class='alert-success'>Record saved successfully</div>";
	}
	/*}
	else
	{
		$msg="<div class='alert-error'>User already exists</div>";
	}*/
	$rsmaxcode=null;
	$rowmaxcode=null;
}
?>

<?php
if(isset($_REQUEST['personcd']))
{
	$personcd=decode($_REQUEST['personcd']);

	$rsPerson=person_details($personcd);
	$rowPerson=getRows($rsPerson);
}
?>
<script language="javascript" type="text/javascript">
function bind_all4()
{
	var ofc_details=document.getElementById('ofc_details');
	if($rowPerson['office']!="" && $rowPerson['designation']!="")
		ofc_details.innerHTML="<?php echo "<label class='text_small'><b>Office Name: </b>".$rowPerson['office']."<br/><b>Desig. of O/C: </b>".$rowPerson['designation']."</label>"; ?>";
}
function bind_all()
{
	var hid_personnel_code=document.getElementById('hid_personnel_code');
	hid_personnel_code.value="<?php echo $rowPerson['personcd']; ?>";
	var offcode=document.getElementById('offcode');
	for (var i = 0; i < offcode.options.length; i++) 
	{
		if (offcode.options[i].value == "<?php echo $rowPerson['officecd']; ?>")
		{
			offcode.options[i].selected = true;
		}
    }
	offcode.readOnly=true;
	var ofc_details=document.getElementById('ofc_details');
	<?php
	if($rowPerson['office']!="" && $rowPerson['designation']!="") { ?>
		ofc_details.innerHTML="<?php echo "<label class='text_small'><b>Office Name: </b>".$rowPerson['office']."<br/><b>Desig. of O/C: </b>".$rowPerson['designation']."</label>"; ?>";
	<?php } ?>
	var empname=document.getElementById('empname');
	empname.value="<?php echo $rowPerson['officer_name']; ?>";
	var designation=document.getElementById('designation');
	for (var i = 0; i < designation.options.length; i++) 
	{
		if (designation.options[i].value == "<?php echo $rowPerson['off_desg']; ?>")
		{
			designation.options[i].selected = true;
		}
    }	
	var dob = document.getElementById('dob');
	dob.value="<?php echo $rowPerson['dateofbirth']; ?>";
	var sex = document.getElementById('sex');
	for (var i = 0; i < sex.options.length; i++) 
	{
		if (sex.options[i].value == "<?php echo $rowPerson['gender']; ?>")
		{
			sex.options[i].selected = true;
		}
    }
	var scale=document.getElementById('scale');
	scale.value="<?php echo $rowPerson['scale']; ?>";
	var basicpay=document.getElementById('basicpay');
	basicpay.value="<?php echo $rowPerson['basic_pay']; ?>";
	var gradepay=document.getElementById('gradepay');
	gradepay.value="<?php echo $rowPerson['grade_pay']; ?>";
	var preaddress1=document.getElementById('preaddress1');
	preaddress1.value="<?php echo $rowPerson['present_addr1']; ?>";
	var preaddress2=document.getElementById('preaddress2');
	preaddress2.value="<?php echo $rowPerson['present_addr2']; ?>";
	var peraddress1=document.getElementById('peraddress1');
	peraddress1.value="<?php echo $rowPerson['perm_addr1']; ?>";
	var peraddress2=document.getElementById('peraddress2');
	peraddress2.value="<?php echo $rowPerson['perm_addr2']; ?>";	
	var workingstatus=document.getElementById('workingstatus');
	for (var i = 0; i < workingstatus.options.length; i++) 
	{
		if (workingstatus.options[i].value == "<?php echo $rowPerson['workingstatus']; ?>")
		{
			workingstatus.options[i].selected = true;
		}
    }
	
	var email=document.getElementById('email');
	email.value="<?php echo $rowPerson['email']; ?>";
	var r_no=document.getElementById('r_no');
	r_no.value="<?php echo $rowPerson['resi_no']; ?>";
	var m_no=document.getElementById('m_no');
	m_no.value="<?php echo $rowPerson['mob_no']; ?>";
	var qualification=document.getElementById('qualification');
	for (var i = 0; i < qualification.options.length; i++) 
	{
		if (qualification.options[i].value == "<?php echo $rowPerson['qualificationcd']; ?>")
		{
			qualification.options[i].selected = true;
		}
    }
	var language=document.getElementById('language');
	for (var i = 0; i < language.options.length; i++) 
	{
		if (language.options[i].value == "<?php echo $rowPerson['languagecd']; ?>")
		{
			language.options[i].selected = true;
		}
    }
	var bank=document.getElementById('bank');
	for (var i = 0; i < bank.options.length; i++) 
	{
		if (bank.options[i].value == "<?php echo $rowPerson['bank_cd']; ?>")
		{
			bank.options[i].selected = true;
		}
    }
	var branch=document.getElementById('branch');
	for (var i = 0; i < branch.options.length; i++) 
	{
		if (branch.options[i].value == "<?php echo $rowPerson['branchcd']; ?>")
		{
			branch.options[i].selected = true;
		}
    }
	var acc_no=document.getElementById('acc_no');
	acc_no.value="<?php echo $rowPerson['bank_acc_no']; ?>";
	var voterof=document.getElementById('voterof');
	voterof.value="<?php echo $rowPerson['acno']; ?>";
	var partno=document.getElementById('partno');
	partno.value="<?php echo $rowPerson['partno']; ?>";
	var sl_no=document.getElementById('sl_no');
	sl_no.value="<?php echo $rowPerson['slno']; ?>";
	var epic_no=document.getElementById('epic_no');
	epic_no.value="<?php echo $rowPerson['epic']; ?>";
	var ac_pre=document.getElementById('ac_pre');
	for (var i = 0; i < ac_pre.options.length; i++) 
	{
		if (ac_pre.options[i].value == "<?php echo $rowPerson['assembly_temp']; ?>")
		{
			ac_pre.options[i].selected = true;
		}
    }
	var ac_per=document.getElementById('ac_per');
	for (var i = 0; i < ac_per.options.length; i++) 
	{
		if (ac_per.options[i].value == "<?php echo $rowPerson['assembly_perm']; ?>")
		{
			ac_per.options[i].selected = true;
		}
    }
	var ac_posting=document.getElementById('ac_posting');
	for (var i = 0; i < ac_posting.options.length; i++) 
	{
		if (ac_posting.options[i].value == "<?php echo $rowPerson['assembly_off']; ?>")
		{
			ac_posting.options[i].selected = true;
		}
    }
	var posting_status=document.getElementById('posting_status');
	for (var i = 0; i < posting_status.options.length; i++) 
	{
		if (posting_status.options[i].value == "<?php echo $rowPerson['poststat']; ?>")
		{
			posting_status.options[i].selected = true;
		}
    }
	var remarks=document.getElementById('remarks');
	remarks.value="<?php echo $rowPerson['remarks']; ?>";
	var group=document.getElementById('group');
	for (var i = 0; i < group.options.length; i++) 
	{
		if (group.options[i].value == "<?php echo $rowPerson['pgroup']; ?>")
		{
			group.options[i].selected = true;
		}
    }
	var hid_file=document.getElementById('hid_file');
	hid_file.value="<?php echo $rowPerson['upload_file']; ?>";
	var link_file=document.getElementById('link_file');
	if(hid_file.value!='')
		link_file.innerHTML="<a href='employee_photo/<?php echo $rowPerson['upload_file']; ?>' target='_blank' class='hp_link'>View Employee Photo</a>";
	
	//OfficeID.readOnly=true;
}
</script>
    
<body oncontextmenu="return false;" onload="javascript: bind_all();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2"><?php print $environment; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">POLICE DETAILS ENTRY</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" enctype="multipart/form-data">
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
    <tr height="40px">
      <td align="left" valign="top"><span class="error">*</span>Office Code</td>
      <td align="left" valign="top"><select name="offcode" id="offcode" style="width:150px;" onchange="fatch_offcdtl(this.value)">
      						<option value="0">-Select Office Code-</option>
                            <?php 	$rsOc=fatch_officecode();
									$num_rows=rowCount($rsOc);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowOc=getRows($rsOc);
											echo "<option value='$rowOc[0]'>$rowOc[0]</option>\n";
										}
									}
									$rsOc=null;
									$num_rows=0;
									$rowOc=null;
							?>
      				</select></td>
      <td align="left" colspan="2" valign="top"><span id="ofc_details"></span></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Name of Police</td>
      <td align="left"><input type="text" name="empname" id="empname" style="width:142px;" /></td>
      <td align="left"><span class="error">*</span>Designation</td>
      <td align="left"><select name="designation" id="designation" style="width:150px;">
      						<option value="0">-Select Designation-</option>
                            <?php 	$rsDes=designation_name();
									$num_rows=rowCount($rsDes);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowDes=getRows($rsDes);
											echo "<option value='$rowDes[0]'>$rowDes[1]</option>\n";
										}
									}
									$rsDes=null;
									$num_rows=0;
									$rowDes=null;
							?>
      				</select></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Date of Birth</td>
      <td align="left"><input type="text" name="dob" id="dob" maxlength="10" style="width:150px;" /></td>
      <td align="left"><span class="error">*</span>Sex</td>
      <td align="left"><select name="sex" id="sex" style="width:150px;">
        <option value="0">-Select-</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select></td>
    </tr>
    <tr>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>Scale of Pay</td>
      <td align="left"><input type="text" name="scale" id="scale" style="width:142px;" maxlength="50" />
        &nbsp;&nbsp; <span class="error">*</span>Basic Pay</td>
      <td align="left"><input type="text" name="basicpay" id="basicpay" style="width:100px;" onkeypress="javascript:return wholenumbersonly(event);" maxlength="6" />
        &nbsp;&nbsp; <span class="error">*</span>Grade Pay</td>
      <td align="left"><input type="text" name="gradepay" id="gradepay" style="width:142px;" onkeypress="javascript:return wholenumbersonly(event);" maxlength="6" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Present Address</td>
      <td align="left" colspan="2"><input type="text" name="preaddress1" id="preaddress1" maxlength="50" style="width:300px;" /><br />
      								<input type="text" name="preaddress2" id="preaddress2" maxlength="50" style="width:300px;" /></td>
      <td align="left"><input type="checkbox" id="chkset" name="chkset" onclick="return chkset_change();" />
        <label for="chkset" class="text_small">Check if present and permanent<br />
          addresses are same</label></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Permanent Address</td>
      <td align="left" colspan="2"><input type="text" name="peraddress1" id="peraddress1" maxlength="50" style="width:300px;" /><br />
      								<input type="text" name="peraddress2" id="peraddress2" maxlength="50" style="width:300px;" /></td>
       <td align="left">
        <label for="chkset" class="text_small">Working 3 years out of 4 years<br />(as on 30.06.2013)</label>&nbsp;&nbsp;<select name="workingstatus" id="workingstatus">
        <option value="Yes">Yes</option>
        <option value="No">No</option></select></td>                             
    </tr>
    <tr>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>Email ID</td>
      <td align="left"><input type="text" name="email" id="email" style="width:142px;" onblur="return email_valid();" maxlength="30" />
        &nbsp;&nbsp; &nbsp;&nbsp;Phone No(R)</td>
      <td align="left"><input type="text" name="r_no" id="r_no" style="width:100px;" maxlength="14" onkeypress="javascript:return wholenumbersonly(event);" />
        &nbsp;&nbsp; <span class="error">*</span>Mobile No</td>
      <td align="left"><input type="text" name="m_no" id="m_no" style="width:142px;" maxlength="12" onkeypress="javascript:return wholenumbersonly(event);" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Qualification</td>
      <td align="left"><select name="qualification" id="qualification" style="width:150px;">
      						<option value="0">-Select Qualification-</option>
                            <?php 	$rsQ=fatch_qualification();
									$num_rows=rowCount($rsQ);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowQ=getRows($rsQ);
											echo "<option value='$rowQ[0]'>$rowQ[1]</option>\n";
										}
									}
									$rsQ=null;
									$num_rows=0;
									$rowQ=null;
							?>
      				</select></td>
      <td align="left"><span class="error">*</span>Language Known (other than Bengali)</td>
      <td align="left"><select name="language" id="language" style="width:150px;">
      						<option value="0">-Select-</option>
                            <?php 	$rsL=fatch_language();
									$num_rows=rowCount($rsL);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowL=getRows($rsL);
											echo "<option value='$rowL[0]'>$rowL[1]</option>\n";
										}
									}
									$rsL=null;
									$num_rows=0;
									$rowL=null;
							?>
      				</select></td>
    </tr>
    <tr><td colspan="2" align="left"><b>Bank Details</b></td></tr>
    <tr>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>Bank</td>
      <td align="left"><select name="bank" id="bank" style="width:150px;" onchange="fatch_branch(this.value,<?php echo $dist_cd ?>)">
      						<option value="">-Select Bank Name-</option>
                            <?php 	$rsBn=fatch_bank();
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
      				</select>
        &nbsp;&nbsp; <span class="error">&nbsp;&nbsp;</span>Branch</td>
      <td align="left"><span id='branch_result'><select name="branch" id="branch" style="width:108px;">
      						<?php
								if(isset($personcd))
								{
									$rsBranch=fatch_branch($rowPerson['bank_cd'],$dist_cd);
									$num_rows = rowCount($rsBranch);
									if($num_rows>0)
									{
										echo "<option value=''>-Select Branch-</option>\n";
										for($i=1;$i<=$num_rows;$i++)
										{
										  $rowBranch=getRows($rsBranch);
										  echo "<option value='$rowBranch[0]'>$rowBranch[3]</option>\n";
										}
									}
									$rsBranch=null;
									$rowBranch=null;
								}
							  ?>
     				 </select></span>
        &nbsp;&nbsp; <span class="error">&nbsp;&nbsp;</span>Bank A/C No</td>
      <td align="left"><input type="text" name="acc_no" id="acc_no" style="width:142px;" /></td>
    </tr>
    <tr><td align="left"><span class="error">*</span>Voter of Assembly</td>
    	<td align="left" colspan="3"><input type="text" name="voterof" id="voterof" style="width:142px;" onkeypress="javascript:return wholenumbersonly(event);" maxlength="3" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Part No</td>
      <td align="left"><input type="text" name="partno" id="partno" style="width:142px;" maxlength="5" />
        &nbsp;&nbsp; <span class="error">*</span>Serial No</td>
      <td align="left"><input type="text" name="sl_no" id="sl_no" style="width:142px;" maxlength="5" />
        &nbsp;&nbsp; <span class="error">*</span>EPIC No</td>
      <td align="left"><input type="text" name="epic_no" id="epic_no" style="width:142px;" maxlength="25" /></td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left"><span class="error">*</span>Present Address</td>
      <td align="left"><span class="error">*</span>Permanent Address</td>
      <td align="left"><span class="error">*</span>Place of Posting</td>
    </tr>
    <tr>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>Assembly of</td>
      <td align="left"><select name="ac_pre" id="ac_pre" style="width:150px;">
      						<option value="0">-Select Assembly-</option>
							<?php 	$subdiv=$subdiv_cd;
									$rsAsPre=fatch_assembly($subdiv);
									$num_rows=rowCount($rsAsPre);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowAsPre=getRows($rsAsPre);
											echo "<option value='$rowAsPre[0]'>$rowAsPre[2]</option>\n";
										}
									}
									$rsAsPre=null;
									$num_rows=0;
									$rowAsPre=null;
							?>
      				</select></td>
      <td align="left"><select name="ac_per" id="ac_per" style="width:150px;">
      						<option value="0">-Select Assembly-</option>
							<?php 	$rsAsPer=fatch_assembly($subdiv);
									$num_rows=rowCount($rsAsPer);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowAsPer=getRows($rsAsPer);
											echo "<option value='$rowAsPer[0]'>$rowAsPer[2]</option>\n";
										}
									}
									$rsAsPer=null;
									$num_rows=0;
									$rowAsPer=null;
							?>
      				</select></td>
      <td align="left"><select name="ac_posting" id="ac_posting" style="width:150px;">
      						<option value="0">-Select Assembly-</option>
							<?php 	$rsAsPos=fatch_assembly($subdiv);
									$num_rows=rowCount($rsAsPos);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowAsPos=getRows($rsAsPos);
											echo "<option value='$rowAsPos[0]'>$rowAsPos[2]</option>\n";
										}
									}
									$rsAsPos=null;
									$num_rows=0;
									$rowAsPos=null;
									$subdiv='0';
							?>
      				</select></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Posting Status</td>
      <td align="left"><select name="posting_status" id="posting_status" style="width:150px;">
      						<option value="0">-Select Posting Status-</option>
                            <?php 	$rsP=fatch_postingstatus();
									$num_rows=rowCount($rsP);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowP=getRows($rsP);
											echo "<option value='$rowP[0]'>$rowP[1]</option>\n";
										}
									}
									$rsP=null;
									$num_rows=0;
									$rowP=null;
							?>
      				</select></td>
      <td align="left"><span class="error">*</span>Remarks</td>
      <td align="left"><input type="text" name="remarks" id="remarks" style="width:142px;" maxlength="30" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>Group</td>
      <td align="left"><select name="group" id="group" style="width:150px;" >
      						<option value="">-Select-</option>
                            <option value="Group-A Staff">Group-A Staff</option>
                            <option value="Group-B Staff">Group-B Staff</option>
                            <option value="Group-C Staff">Group-C Staff</option>
                            <option value="Group-D Staff">Group-D Staff</option>
      					</select></td>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>Picture</td>
      <td align="left"><input type="file" id="file" name="file" onchange="return validateFileExtension(this);" width="300px" /></td>
    </tr>
    <tr>
	  <td align="left" class="error" colspan="2">*Picture size should be between 10kb & 30kb</td>
      <td align="left">&nbsp;</td>
      <td align="left" id="link_file">&nbsp;</td>
      <input type="hidden" id="hid_personnel_code" name="hid_personnel_code" />
      <input type="hidden" id="hid_file" name="hid_file" />
    </tr>
    <tr>
      <td colspan="4" align="center"><input type="submit" name="submit" id="submit" value="Save" class="button" onclick="javascript:return validate();" /></td>
    </tr>
    <tr><td colspan="4" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
  </table>
</form>
</td></tr></table>
</td></tr>
</table>
</div>
<div align="center"></div>
<div id="calendar" style="width: 243px;display:none;"></div>  
<script>
                $(document).ready(function() {
                    $("#calendar").kendoCalendar();

                    var calendar = $("#calendar").data("kendoCalendar");
                    calendar.value(new Date());

                    var navigate = function () {
                        var value = $("#direction").val();
                        switch(value) {
                            case "up":
                                calendar.navigateUp();
                                break;
                            case "down":
                                calendar.navigateDown(calendar.value());
                                break;
                            case "past":
                                calendar.navigateToPast();
                                break;
                            default:
                                calendar.navigateToFuture();
                                break;
                        }
                    },
                    setValue = function () {
                        calendar.value($("#dob").val());
                    };

                    $("#get").click(function() {
                        alert(calendar.value());
                    });

                    $("#dob").kendoDatePicker({
                        change: setValue
                    });


                    $("#set").click(setValue);

                    $("#direction").kendoDropDownList({
                        change: navigate
                    });

                    $("#navigate").click(navigate);
                });
           </script>
</body>
</html>