<?php
session_start();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contact Us</title><?php
include('header/header.php');
include('function/contactus.php');
?>
</head>
    <link rel="stylesheet" type="text/css" href="themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="themes/icon.css">
	<script type="text/javascript" src="jq/jquery.min.js"></script>
	<script type="text/javascript" src="jq/jquery.easyui.min.js"></script>   
<body>
<script>

function reply_person(str)
{
	location.replace("reply-details.php?pid="+str);
}
</script>
<script type="text/javascript" language="javascript">
        function selectCheckBox()
        {
            var total="";
            for(var i=0; i < document.form.languages.length; i++)
            {
                if(document.form.languages[i].checked)
                {
                    total +=document.form.languages[i].value + ",";
                }
            }
            if(total=="")
            {
               /***************** all***********************/
			   if(!$("#check1").is(":checked"))
	   {
	        if($('#to').val()==0)
			{
				 $('#msg').html("Select Sender");
				 return false;
			}
			var status=0;
	   }
	   else
	   {
		   <?php if($usercd!=1){ ?>
		   var status=1;
		   <?php }?>
		     var status=$('#check1').val();
	   }
		   if($('#query').val()=="")
			{
				 $('#msg').html("Enter Something");
				 return false;
			}
		   var to=$('#to').val();
		  // alert(to);
	       //var subject=$('#subject').val();
		   var subject='';
	       var query=$('#query').val();
		   
		   progress();
		  $.ajax({
			      type:"get",
			      url: "ajax-contactus.php",
			      cache: false,
			      data: "to="+to+"&subject="+subject+"&query="+query+"&status="+status+"&opn=save",
				 
			    success: function(data) {
			       location.reload();
					 
			   }
		      });
			   
			   /********************************************/
            }
            else{
				
				/**********************************data send *****************************/
				
				
				if(!$("#check1").is(":checked"))
	   {
	        if($('#to').val()==0)
			{
				 $('#msg').html("Select Sender");
				 return false;
			}
			var status=0;
	   }
	   else
	   {
		   <?php if($usercd!=1){ ?>
		   var status=1;
		   <?php }?>
		     var status=$('#check1').val();
	   }
		   if($('#query').val()=="")
			{
				 $('#msg').html("Enter Something");
				 return false;
			}
		  // var to=$('#to').val();
		  // alert(to);
	       //var subject=$('#subject').val();
		   var to=total;
		   var subject='';
	       var query=$('#query').val();
		   
		   progress();
		  $.ajax({
			      type:"get",
			      url: "ajax-contactus.php",
			      cache: false,
			      data: "to="+to+"&subject="+subject+"&query="+query+"&status="+status+"&opn=save",
				 
			    success: function(data) {
			       location.reload();
				   //alert(data);
					 
			   }
		      });
				
				
				/*************************************************************************/
                ///alert("Selected Values are : \n"+total);
            }
        }
		
		
		function reply_click(code){
		if(code==1){
			$("#disply_na").hide();
		}
				
	}
    </script>
<?php
$usercd=$user_cd;

?>

<div align="center">
	<div class="easyui-layout" style="width:80%;height:600px;">
	  
		<div data-options="region:'center'" title="Contact Us">
        <!--Message send start-->	
	
			<div data-options="region:'center'" style="padding:0px;">
			   <!--<form method="post" name="form1" id="form1" autocomplete='off'>-->
               <form id="form" name="form" method="post" action="CheckBox.jsp">
               
                <table width="95%" class="form" cellpadding="0">
               
                   <tr><td align="center" colspan="3"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
                    <!-- <tr><td height="18px" colspan="3" align="center"><?php //print $msg; ?><span id="msg" class="error"></span></td></tr>
                     <tr><td align="center" colspan="3"><img src="images/blank.gif" alt="" height="5px" /></td></tr>-->
                      <tr><td align="left" width="6%"><?php if($usercd==1){?><span class="error">*</span>To<?php } ?></td>
                          <td align="left" width="18%">
                          
       <!-- <form id="form" name="form" method="post" action="CheckBox.jsp">-->
        <?php  if($usercd==1){?>
            <div style="overflow: auto; width: 250px; height: 80px; border: 1px solid #336699; padding-left: 5px" id="disply_na">
            
            
            
            <?php 
			//if($usercd==1){
				$rsto=fetch_userid($usercd);
                                                    $num_rows=rowCount($rsto);
                                                    if($num_rows>0)
                                                    {
                                                        for($i=1;$i<=$num_rows;$i++)
                                                        {
                                                            $rowto=getRows($rsto);
															
                                                            //echo "<option value='$rowto[0]'>$rowto[1]</option>";
															?>
                                                            <input type="checkbox" name="languages" value="<?php echo $rowto[0]; ?>"><?php echo $rowto[1]; ?><br>
                                                            <?php
															
                                                        }
                                                    }
                    ?>
                     </div>
                    <?php
					                                unset($rsto,$num_rows,$rowto);
													
			}else{
				?>
                <div style="overflow: auto; width: 250px; height: 80px; border: 1px solid #336699; padding-left: 5px; display:none;" id="disply_na">
                <?php
				
				$rsto=fetch_userid($usercd);
                                                    $num_rows=rowCount($rsto);
                                                    if($num_rows>0)
                                                    {
                                                        for($i=1;$i<=$num_rows;$i++)
                                                        {
                                                            $rowto=getRows($rsto);
															
                                                            //echo "<option value='$rowto[0]'>$rowto[1]</option>";
															?>
                                                            <input type="checkbox" name="languages" value="<?php echo $rowto[0]; ?>" <?php if($rowto[0]==1){ ?> checked <?php } ?> ><?php echo $rowto[1]; ?><br>
                                                            <?php
															
                                                        }
                                                    }
                                                    unset($rsto,$num_rows,$rowto);
													?>
                                                    </div>
                                                    <?php 
				
			}
												
												
												?>
           
            
            <?php //} ?>
        <!--</form>-->
						  
						  <?php  if($usercd==1){?><input type="checkbox" name="check1" id="check1" value="1" <?php if($usercd!=1){ ?>checked disabled <?php } ?> onClick="javascript:return reply_click(this.value)" />All Users <?php }else{ ?>Message<?php } ?></td><td><textarea id="query" name="query" maxlength="200" style="min-width: 750px;min-height: 100px;"></textarea>
                         
                         </td></tr>
                        
                       
                     <tr><td colspan="3" align="center"></td></tr>
                    <tr><td colspan="3" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
                    <tr><td colspan="3" align="center">
                    <div data-options="region:'south',border:false" style="text-align:right;">
				<!--<a onClick="save();" data-options="iconCls:'icon-ok'" class="easyui-linkbutton" style="width:80px; margin-right:12px;">
                Send</a>-->
                <input type="button" name="goto" onClick="selectCheckBox()"  class="easyui-linkbutton" style="width:80px;" value="Send">
                    </div></td></tr>
                </table>
            </form>
	 </div>
        
        
        
         <!--Message send end-->
           <div class="easyui-tabs" data-options="fit:true,border:false,plain:true" >
				<div title="Query" style="padding-bottom: 45px" >
                    
                    <div id='watingdiv' style="display: none; font-size: 12px; font-weight:bold">
                        <img src="images/loading1.gif"> loading...
                    </div>
                      <table width="100%">
							<tr>
								<td id="contact_details"></td>
								
							</tr>
                                                
					</table>
                   
                </div>
                <div title="Reply" style="padding-bottom: 45px" >
                    
                    <div id='watingdiv12' style="display: none; font-size: 12px; font-weight:bold">
                        <img src="images/loading1.gif"> loading...
                    </div>
                    
                      <table width="100%">
							<tr>
								<td id="contact_reply"></td>
								
							</tr>
                                                
					</table>
                   
                </div>
               
           </div>
		</div>
	</div>
</div>


</body>
<script type="text/javascript" language="javascript">
$(document).ready(function(){ 
	  $('#check1').click(function() {
        if($(this).is(":checked"))
        {
			 $('#send_to').hide();
			 $('#to').val("0");
          
        } else {
             $('#send_to').show();
        }
    });
	list_details('contactus.php');
	list_details1('contactus.php');
	sent_details('contactus.php');
	
});

function list_details(str)
{
	var page=str;
	var data= {page:page,opn:'contactdetails'};
	$('#watingdiv').show();
	$.ajax({
		type:"post",
		url: "ajax-contactlist.php",
		cache: false,
		data: data,
		success: function(data1) {	
		$("#contact_details").html(data1);
	      $('#watingdiv').hide();
		}
	});
}

function list_details1(str)
{
	var page=str;
	var data= {page:page,opn:'contactdetails'};
	$('#watingdiv12').show();
	$.ajax({
		type:"post",
		url: "ajax-contactlist1.php",
		cache: false,
		data: data,
		success: function(message) {	
		$("#contact_reply").html(message);
	      $('#watingdiv12').hide();
		}
	});
}
function sent_details(str)
{
	var page=str;
	var data= {page:page,opn:'sentdetails'};
	$('#watingdiv1').show();
	$.ajax({
		type:"post",
		url: "ajax-sentlist.php",
		cache: false,
		data: data,
		success: function(data1) {	
		$("#sent_details").html(data1);
	      $('#watingdiv1').hide();
		}
	});
}

function progress(){
			var win = $.messager.progress({
				title:'Please waiting',
				msg:'Sending...'
			});
			
		}
function loading(){
			var win = $.messager.progress({
				title:'Please waiting',
				msg:'loading...'
			});
			
		}
</script>
</html>
