<form id="myform" method="post" action="" target="" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="2">
    <tr>
      <td align="right" class="type-one">&nbsp;</td>
      <td align="left" class="type-one"><strong>
        <input name="op" type="hidden" id="op" value="1" />
      </strong></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td width="19%" align="right" class="type-one">Username: </td>
      <td width="43%" align="left" class="type-one"><input name="username" type="text" class="ilaw" id="username" onfocus="this.style.margin = '0'; this.style.borderWidth = '2px'; this.style.backgroundColor = '#FFFFFF';" onblur="this.style.margin = '1px'; this.style.borderWidth = '1px'; this.style.backgroundColor = '#E9F0F5';" onkeyup="check_id_available(this.form)" value="<?php echo $user->username; ?>" size="35"/>
      </td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" class="type-one">Department / Office:</td>
      <td align="left" class="type-one"><?php echo form_dropdown('office_id', $options, $user->office_id); ?></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" class="type-one">Last name: </td>
      <td align="left" class="type-one"><input name="lname" type="text" id="lname" value="<?php echo $user->lname; ?>" size="35" class="ilaw" onfocus="this.style.margin = '0'; this.style.borderWidth = '2px'; this.style.backgroundColor = '#FFFFFF';" onblur="this.style.margin = '1px'; this.style.borderWidth = '1px'; this.style.backgroundColor = '#E9F0F5';"/></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" class="type-one">First name: </td>
      <td align="left" class="type-one"><input name="fname" type="text" id="fname" value="<?php echo $user->fname; ?>" size="35" class="ilaw" onfocus="this.style.margin = '0'; this.style.borderWidth = '2px'; this.style.backgroundColor = '#FFFFFF';" onblur="this.style.margin = '1px'; this.style.borderWidth = '1px'; this.style.backgroundColor = '#E9F0F5';"/></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" class="type-one">Middle Name: </td>
      <td align="left" class="type-one"><input name="middle" type="text" id="middle" value="<?php echo $user->mname; ?>" size="35" class="ilaw" onfocus="this.style.margin = '0'; this.style.borderWidth = '2px'; this.style.backgroundColor = '#FFFFFF';" onblur="this.style.margin = '1px'; this.style.borderWidth = '1px'; this.style.backgroundColor = '#E9F0F5';"/></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" class="type-one">Password:</td>
      <td align="left" class="type-one"><input name="password" type="password" id="password" size="35" class="ilaw" onfocus="this.style.margin = '0'; this.style.borderWidth = '2px'; this.style.backgroundColor = '#FFFFFF';" onblur="this.style.margin = '1px'; this.style.borderWidth = '1px'; this.style.backgroundColor = '#E9F0F5';"/></td>
      <td width="38%" align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" class="type-one">Re - type password: </td>
      <td align="left" class="type-one"><input name="repassword" type="password" id="repassword" size="35" class="ilaw" onfocus="this.style.margin = '0'; this.style.borderWidth = '2px'; this.style.backgroundColor = '#FFFFFF';" onblur="this.style.margin = '1px'; this.style.borderWidth = '1px'; this.style.backgroundColor = '#E9F0F5';"/></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" class="type-one">Group:</td>
      <td align="left" class="type-one"><?php echo form_dropdown('group_id', $groups_options, $groups_selected); ?></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" class="type-one">&nbsp;</td>
      <td align="left" class="type-one"><strong>
        <input type="submit" name="button2" id="button" value="Save" class="button"/>
        </strong><a href="<?php echo Request::root().'/users'?>">Cancel</a></td>
      <td align="left">&nbsp;</td>
    </tr>
</table>
<div></div>
</form>