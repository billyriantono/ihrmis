<?php if (validation_errors()): ?>
<div class="clean-red"><?php echo validation_errors(); ?></div>
<?php elseif (Session::flashData('msg')): ?>
<div class="clean-green"><?php echo Session::flashData('msg'); echo $msg;?></div>
<?php else: ?>
<?php endif; ?>

<?php if ( $msg != '' ): ?>
<div class="clean-green"><?php echo $msg;?></div>
<?php endif; ?>
<table width="100%" border="0">
  <tr>
    <td width="8%">&nbsp;</td>
    <td width="72%">&nbsp;</td>
    <td width="20%"><a href="<?php echo base_url().'attendance/employee_schedule_save'?>">Create Employee Schedule</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<form method="post" action="" enctype="multipart/form-data">
<table id="dtr.table" width="100%" border="0" class="type-one">
  <tr class="type-one-header">
    <th width="5%" bgcolor="#D6D6D6">ID</th>
    <th width="24%" bgcolor="#D6D6D6"><strong>Description</strong></th>
    <th width="24%" bgcolor="#D6D6D6">Date</th>
    <th width="22%" bgcolor="#D6D6D6">Schedule</th>
    <th width="15%" bgcolor="#D6D6D6">Employees</th>
    <th width="10%" bgcolor="#D6D6D6">Actions</th>
    </tr>
    <?php $s = new Schedule();?>
  <?php foreach($rows as $row):?>
  	<?php $s->get_by_id( $row->schedule_id);?>
  <?php $bg = $this->Helps->set_line_colors();?>
			
  <tr bgcolor="<?php echo $bg;?>" onmouseover="this.bgColor = '<?php echo $this->config->item('mouseover_linecolor')?>';" 
    onmouseout ="this.bgColor = '<?php echo $bg;?>';" style="border-bottom: 1px solid #999999;">
    <td><?php echo $row->id;?></td>
    <td><?php echo $row->name;?></td>
    <?php $dates = unserialize($row->dates);?>
    <td><?php echo $dates['month'].'-'.$dates['period_from'].'-'.$dates['year'].' to '.$dates['month'].'-'.$dates['period_to'].'-'.$dates['year'];?></td>
    <td><?php echo $s->name;?></td>
    <td><a href="<?php echo base_url();?>attendance/employee_schedule_view_employees/<?php echo $row->id;?>">View Employees</a></td>
    <td><a href="<?php echo base_url();?>attendance/employee_schedule_save/<?php echo $row->id;?>/<?php echo $page;?>">Edit</a> | <a href="<?php echo base_url();?>attendance/employee_schedule_delete/<?php echo $row->id;?>/<?php echo $page;?>" class="delete_row">Delete</a></td>
    </tr>
  <?php endforeach;?>
  <tr>
    <td>&nbsp;</td> <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td> 
  </tr>
</table>
</form>
<script>
$('.delete_row').click(function(){

	var answer = confirm("Are you sure?")
	
	if (!answer)
	{
		return false;
	}
});
</script>