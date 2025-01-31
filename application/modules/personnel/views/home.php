<?php
/*
//1.Process dtr check for late and undertime
//2.
$employee_ids = $Employee->get_selected_field('id');
//echo '<pre>';
//print_r($employee_ids);
//echo '</pre>';


foreach($employee_ids  as $employee_id)
{
	$between_from = date('Y').'-'.date('m').'-01';
	$between_from = date('Y').'-'.date('m').'-'.date('d');
	$between_to   = date('Y').'-'.date('m').'-'.date('d');
	
	//$dtr_result = $Dtr->employee_dtr($between_from, $between_to, $employee_id);
	//print_r($dtr_result);
	//exit;
	//get employee info
	$name = $Employee->get_employee_info($employee_id);
	
	//PROCESS THIS IF THE SHIFT ID IS EQUAL TO 1 OR REGULAR OFFICE HOURS
	if($name['shift_type'] == 1)
	{
		$shiftTime = $Shift->shift_times($name['shift_type'], 1);
		
		$time_a = $shiftTime['time_a'];
		$time_b = $shiftTime['time_b'];
		$time_c = $shiftTime['time_c'];
		$time_d = $shiftTime['time_d'];
		
		
		//use this if the agency wants to have 15mins grace period
		$time_a = $Office->is_compensatory($name['office_id']);//echo $time_d;
	}
	
	###### just store the result of the succeeding query
	$dtr_result = $Dtr->employee_dtr($between_from, $between_to, $employee_id);
	
	//check if the employee has data in manual log table
	//$manual_log_result = $Manual_Log->employee_manual_log($employee_id);
	
	//late counter (minutes or hours late)
	$late_final = 0;
	
	//late count (number of lates
	$late_count = 0;
	
	//undertime
	$undertime_final = 0;
	
	//undertime count (number of undertime)
	$undertime_count = 0;
	
	$line_number = 1;
	
	//number of days work
	$number_of_days = 0;

	//number of overtime
	$finalOverTime = 0;
	//overtime
	$overtime = 0;
	
	//NUMBER OF HOURS WORKED
	$number_of_hours_work = 0;
	
	if(is_array($dtr_result))
	{
		//process the dtr
		foreach ($dtr_result as $row)
		{
			
			$am_login = $row['am_login'];
			$am_logout= $row['am_logout'];
			$pm_login = $row['pm_login'];
			$pm_logout= $row['pm_logout'];
			$ot_login = $row['ot_login'];
			$ot_logout= $row['ot_logout'];
			$leave_type_id = $row['leave_type_id'];
			$log_date = $row['log_date'];
			$manual_log_id = $row['manual_log_id'];
			
			//split the logged_date
			list($log_year, $log_month, $log_day) = split('[-.-]', $log_date);
			
			//Check if the day is Sat or Sun
			$sat_or_sun = $Settings->is_sat_sun($log_month, $log_day, $log_year);
			
			$date_is_holiday = date("Y-m-d", strtotime($log_date));
			//Check if the day is holiday
			$isHoliday = $Holiday->is_holiday($log_date);
			
			//If the day Name is sat or sun or holiday // Do nothing  (Dont compute Tardiness)
			if ($sat_or_sun == 'Saturday' || $sat_or_sun == 'Sunday' || $isHoliday == TRUE)
			{
				$Tardiness->delete_tardiness($employee_id, $log_date, 0);
			}
			
			else
			{
				//*****THIS IS TO CHECK FOR THE LATE*******
					
				//am login and pm login check if late
				$late = $Settings->check_late($am_login, $time_a, $pm_login, $time_c);
				//echo $time_a;
				//If there is no late
				//Check if the date has tardiness
				//that entered during dtr viewing
				//(use if the tardiness has been updated 
				//with the wrong dtr record
				//for ex: there is no out so it will generate 
				//a large amount of tardiness
				$Tardiness->delete_tardiness($employee_id, $log_date, $late['am_login']);
				$Tardiness->delete_tardiness($employee_id, $log_date, $late['pm_login']);
				
				//am logout check if undertime
				$undertime = $Settings->check_undertime($am_logout, $time_b, $pm_logout, $time_d);
				
				$Tardiness->delete_tardiness($employee_id, $log_date, $undertime['am_logout']);
				$Tardiness->delete_tardiness($employee_id, $log_date, $undertime['pm_logout']);
				
				//If there is a late in am_login
				if ($late['am_login'] != 0)
				{
					$Tardiness->check_tardiness($employee_id, $log_date, $logType = 1, $numberOfSeconds = $late['am_login']);
				}
				
				//If there is a late in pm_login
				if ($late['pm_login'] != 0)
				{
					$Tardiness->check_tardiness($employee_id, $log_date, $logType = 3, $numberOfSeconds = $late['pm_login']);
				}
					
				//late count (number of lates)
				$late_count += $late['count'];
						
				//late counter (minutes or hours late)
				$late_final = $late_final + $late['hours'];
					
				/*****************************************
				******************************************
				***THIS IS TO CHECK FOR THE LATE(END)****/
					
				/*****************************************
				******************************************
				*****THIS IS TO CHECK FOR THE UNDERTIME**
					
				//If there is a undertime in am_logout
				if ($undertime['am_logout'] != 0)
				{
					$Tardiness->check_tardiness($employee_id, $log_date, $logType = 2, $numberOfSeconds = $undertime['am_logout']);
				}
				
				//If there is a undertime in pm_logout
				if ($undertime['pm_logout'] != 0)
				{
					$Tardiness->check_tardiness($employee_id, $log_date, $logType = 4, $numberOfSeconds = $undertime['pm_logout']);
				}
	
				//undertime count (number of undertime
				$undertime_count += $undertime['count'];
						
				//undertime counter (minutes or hours late)
				$undertime_final = $undertime_final + $undertime['hours'];
						
				/*****************************************
				******************************************
				***THIS IS TO CHECK FOR THE UNDERTIME(END)*
				
			}
			
		}
	}		
}

*/


// Employees with tardy
$this->Tardiness->get_employees_ten_tardy(date('m'), date('m'), date('Y'), '');
$tardis =  $this->Tardiness->employees;

echo Session::flashData('msg');

echo $msg;



?>


<input name="d_check" type="checkbox" id="d_check" value="1" onclick="show_div('div1', this)"/><label for="d_check">Download data from machine</label><br />
<div id="div1" style="display:none">
<fieldset><legend>Download data from machine</legend>
<table width="100%" border="0">
  <tr>
    <td colspan="2"><?php //echo $msg;?>
    <div id="download_msg"></div></td>
    <td width="55%">&nbsp;</td>
  </tr>
  <tr>
    <td><input name="connect" type="radio" value="net" id="radiobutton" />
      <label for="radiobutton">Net Connect IP Address:</label>      </td>
    <td><input name="ip" type="text" id="ip" value="<?php echo $ip;?>" />
      <input name="op" type="hidden" id="op" /></td>
    <td><input name="connect_machine" type="button" class="button" id="connect_machine" value="Download Logs"/></td>
  </tr>
  <tr>
    <td><input name="connect" type="radio" value="com" id="radio" />
      <label for="radio">Com Connect</label></td>
    <td>ComNumber: 
      <input name="com_no" type="text" disabled="disabled" id="com_no" value="0" size="2" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="24%">     </td>
    <td width="21%"> MachineNumber: 
      <input name="machine_no" type="text" disabled="disabled" id="machine_no" value="0" size="2" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>
      <input name="delete_data" type="checkbox" id="delete_data" value="1" />
    Delete data from machine after download</label></td>
    <td><input type="hidden" name="MAX_FILE_SIZE" value="10000000000"/></td>
    <td>&nbsp;</td>
  </tr>
</table>
</fieldset>
</div>


<input name="upload_check" type="checkbox" id="upload_check" value="1" onclick="show_div('div2', this)"/><label for="upload_check">Upload data to main Server</label><br />
<div id="div2" style="display:none">

<fieldset><legend>Upload data to main Server</legend><table width="100%" border="0">
  <tr>
    <td width="60%">Period 
      <select name="month" id="month"  >
        <option value="01">January</option>
        <option value="02">February</option>
        <option value="03">March</option>
        <option value="04">April</option>
        <option value="05">May</option>
        <option value="06">June</option>
        <option value="07">July</option>
        <option value="08">August</option>
        <option value="09">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
      </select>
      <select name="period_from" id="period_from" >
        <option value="01">01</option>
      </select>
To:
<select name="period_to" id="period_to" >
  <option value="01">01</option>
  <option value="02">02</option>
  <option value="03">03</option>
  <option value="04">04</option>
  <option value="05">05</option>
  <option value="06">06</option>
  <option value="07">07</option>
  <option value="08">08</option>
  <option value="09">09</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="23">23</option>
  <option value="24">24</option>
  <option value="25">25</option>
  <option value="26">26</option>
  <option value="27">27</option>
  <option value="28">28</option>
  <option value="29">29</option>
  <option value="30">30</option>
  <option value="31">31</option>
</select>
<select name="year" id="year" >
  <option value="2010">2010</option>
  <option value="2011">2011</option>
</select></td>
    <td width="37%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
  </tr>
  <tr>
    <td><div id="upload_msg"></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>
      <input name="download_zip" type="checkbox" id="download_zip" value="1" />
      Just download the zip file(For manual processing)</label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="upload_data" type="button" class="button" id="upload_data" value="Upload data to main server"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</fieldset>
</div>
<input name="xml" type="checkbox" id="xml" value="1" onclick="show_div('div4', this)" /><label for="xml">Manual Upload data</label>
<form target="upload_iframe" name="upload_form" action="<?php echo base_url().'utility/manual_upload_data';?>" enctype="multipart/form-data" method="post">
<div id="div4" style="display:none">
<!--<div id="div4" style="display:block">-->
<fieldset><legend>Manual Upload data (For administrator use only)</legend>
<iframe name="upload_iframe" style="width: 400px; height: 100px; display: none;">
</iframe>
<table width="100%" border="0">
  <tr>
    <td><div id="upload_status"></div></td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td><input type="hidden" name="fileframe" value="true"><input type="file" name="file" id="file" onChange="jsUpload(this)"/> (ex: 21-2009-11-26.zip)
      <input name="filename" type="hidden" id="filename" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</fieldset>
</div>
</form>
<script type="text/javascript">
        //http://av5.com/docs/changing-parent-window-s-url-from-iframe-content.html
		function change_parent_url(url)
        {
	    document.location=url;
        }		
    </script>
<script type="text/javascript">
/* This function is called when user selects file in file dialog */
function jsUpload(upload_field)
{
    // this is just an example of checking file extensions
    // if you do not need extension checking, remove 
    // everything down to line
    // upload_field.form.submit();

    var re_text = /\.txt|\.xml|\.zip/i;
    var filename = upload_field.value;

    /* Checking file type */
    if (filename.search(re_text) == -1)
    {
        alert("File does not have text(txt, xml, zip) extension");
        upload_field.form.reset();
        return false;
    }

    upload_field.form.submit();
	
    document.getElementById('upload_status').innerHTML = "<b><font color=red>Uploading file...</font></b>";
	
	
	//var url="http://localhost/ats_service/xmlrpc_server/manual_upload/"+filename
    //upload_field.disabled = true;
	//upload_field.form.reset();
    return true;
}
</script>

<!-- For debugging purposes, it's often useful to remove
     "display: none" from style="" attribute -->
<fieldset><legend>Stats</legend>
<table width="100%" border="0">
  <tr>
    <td><a href="<?php echo base_url();?>home/home_page/aso/?keepThis=true&TB_iframe=true&height=570&width=950" title="add a caption to title attribute / or leave blank" class="thickbox">Example 1</a>  <a href="http://localhost/hris/0.4/employees/modal_edit_employee/20065004?keepThis=true&TB_iframe=true&height=570&width=950" title="add a caption to title attribute / or leave blank" class="thickbox">Example 1</a>
<a href="ajaxOverFlow.htm?keepThis=true&TB_iframe=true&height=300&width=500" title="add a caption to title attribute / or leave blank" class="thickbox">Example 2</a>
<a href="iframeModal.html?placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=300&modal=true" title="add a caption to title attribute / or leave blank" class="thickbox">Open iFrame Modal</a> </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Month</td>
    <td> Name</td>
    <td>Number of Tardiness</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
  
  if (count($tardis) >= 1){
   
  foreach($tardis as $tardi)
  {
	$this->Employee->fields = array('lname', 'fname');
	
	$name = $this->Employee->get_employee_info($tardi);
	
	$tardiness = $this->Tardiness->count_tardiness($tardi, date('m'), date('Y'), 1, 3);
	$tardiness2 = $this->Tardiness->count_tardiness($tardi, date('m'), date('Y'), 2, 4);
		
	$total_tardiness = $tardiness['tardi_count'] + $tardiness2['tardi_count'];
  ?>
  <tr>
    <td><?php echo date('F, Y');?></td>
    <td><?php echo $name['lname'].', '.$name['fname'];?></td>
    <td><?php echo $total_tardiness; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php 
  }
  
  }
  ?>
</table>
</fieldset>

<script>

$('#radio').click(function(){

	$('#ip').attr("disabled", true);
	$('#com_no').attr("disabled", false);
	$('#machine_no').attr("disabled", false);
	$('#com_no').val(1);
	$('#machine_no').val(1);
});

$('#radiobutton').click(function(){

	$('#ip').attr("disabled", false);
	$('#com_no').attr("disabled", true);
	$('#machine_no').attr("disabled", true);
	$('#com_no').val(0);
	$('#machine_no').val(0);
});


//Use for uploading data to main server
//or just use for creating xml file in zip
$('#upload_data').click(function(){

	$('#upload_msg').html('<b>Please wait...</b><img src="<?php echo base_url();?>images/mozilla_blu.gif" width="16" height="16" />')
	
	var month 		= $('#month').val();
	var period_from = $('#period_from').val();
	var period_to 	= $('#period_to').val();
	var year 		= $('#year').val();
	
	var date1 = year + "-" + month + "-" + period_from
	var date2 = year + "-" + month + "-" + period_to
	
	var ip = ""
	
	var download_zip = "";
	
	if($('#download_zip').is(':checked'))
	{
		download_zip = true;
	}
	else
	{
		download_zip = false;
	}

	var url="<?php echo base_url()?>ajax/upload_data_server/"+date1+"/"+date2+"/"+download_zip
	
	//alert(url)
	$.ajax({
   		type: "POST",
   		url: url,
   		data: "",
   		success: function(msg){
     		//alert( "Data Saved: " + msg );
			$('#upload_msg').html(msg);
   		}
		
 	});
	
	

});


//change the value of button
$('#download_zip').click(function(){

	if($(this).is(':checked'))
	{
		$('#upload_data').val("Download");
	}
	else
	{
		$('#upload_data').val("Upload data to main server");
	}

});


// Connect to t4
$('#connect_machine').click(function(){

	
	var ip 			= $('#ip').val();
	var com_no 		= $('#com_no').val();
	var machine_no 	= $('#machine_no').val();
	
	$('#download_msg').html('<b>Connecting...</b><img src="<?php echo base_url();?>images/mozilla_blu.gif" width="16" height="16" />');
	
	$('#download_msg').load('<?php echo base_url();?>ajax/connect_machine/' + ip + "/" + com_no + "/" + machine_no);
	
});

</script>