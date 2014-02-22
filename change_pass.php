<script src="js/FormValidation.js"></script>
<?php
//include("header/header.php");
$action=$_REQUEST['action'];
$user=$_REQUEST['user'];
$old_pass=$_REQUEST['old_pass'];
$new_pass=$_REQUEST['new_pass'];
$re_new_pass=$_REQUEST['re_new_pass'];

if($action=='Submit')
{

$sql="select count(*) as cnt from contact_master where user_id='$user_id' and user_pwd='$old_pass' " ;

//echo "$sql<br>";
$result=execSelect($sql) ;
$row=getRows($result);
$cnt=$row['cnt'];
if($cnt>0)
{
if($new_pass==$re_new_pass)
{
  $sql_up="update contact_master set ";
  $sql_up.=" user_pwd='$new_pass'";
  $sql_up.=" where  user_id='$user_id'";
 //echo"$sql_up<br>";
  execUpdate($sql_up);
  $msg="Password changed successfully";
}else
{
$msg="Wrong New Password & Re-Enter Password ....";
}

}else if($cnt<=0)
{
$msg="User Not Exists/Old Password is wrong ";
}

}

?>
<script language="javascript">
function check1()
{
  if(document.form1.user.value=='')
  {
    alert('USER ID NOT BLANK..');
    document.form1.user.focus();
    return false;
  }
  else if(document.form1.old_pass.value=='')
  {
    alert('EXISTING PASSWORD CANNOT BE BLANK..');
    document.form1.old_pass.focus();
    return false;
  } else if(document.form1.new_pass.value=='')
  {
    alert('NEW PASSWORD CANNOT BE BLANK..');
    document.form1.new_pass.focus();
    return false;
  } else if(document.form1.re_new_pass.value=='')
  {
    alert('RE-ENTER NEW CANNOT BE BLANK..');
    document.form1.re_new_pass.focus();
    return false;
  }
  return true;
}
</script>
  <div id="content">
    <div class="content_all">

      <div class="content-outer">
        <div class="content-inner">
          <div class="title_border_nopadd">
           <center>
                <form name="form1" method="post" >

                <table width="70%" border="0" class="table_blue" >
                <tr class="tr_blue">
                <td colspan="2" align="center">
                Change Password
                </td>
                </tr>
                <tr>
                <td width="50%" align="right" >Old Password</td>
                <td width="50%">
                <input type="password" name="old_pass"  size='30' value='<?php echo $old_pass; ?>' class="text_left">
                </td>
                </tr>
                <tr>
                <td width="50%" align="right" >New Pass</td>
                <td width="50%">
                <input type="password" name="new_pass"  size='30' value='<?php echo $new_pass; ?>' class="text_left">
                </td>
                </tr>
                <tr>
                <td width="50%" align="right" >Re-Enter New Pass</td>
                <td width="50%">
                <input type="password" name="re_new_pass"  size='30' value='<?php echo $re_new_pass; ?>' class="text_left">
                </td>
                </tr>
                <br>
                <tr>
                <td width="100%" colspan=2 align="center"  >
                <input type="submit" name="action" value="Submit" class="button" onClick="return check1();">&nbsp;&nbsp;
                <input type="button" name="reset" value="Refresh" class="button" onClick="window.location.href='./change_pass.php'">&nbsp;&nbsp;
                </td>
                </tr>
                </table>
                <font color='red'>
                <?php echo $msg; ?>
                </font>

                </form>
            </center>
          </div>

        </div>
      </div>

       <br style="clear:left;"/>
    </div>
    <br style="clear:left;"/>
  </div>
  <br style="clear:left;"/>
  <!--[if !IE]>end content<![endif]-->
  <!--[if !IE]>start footer<![endif]-->
 <?php
//include("footer.php");
 ?>