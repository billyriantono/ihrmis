  </div>
</div>
<div class="no_float"></div>
</div>
<div id="old-foot">
<div align="center"><?php echo $this->Helps->footer(); echo ' (Database Version '.$this->Migrations->get_version().')';?> | Copyright © 2008 - <?php echo date('Y');?> <a href="http://www.charliesoft.net/" class="footerLink" target="_new">Charliesoft</a>. All Rights Reserved.</div>
</div>
</body>
<!--
<script>
var isInIFrame = (window.location != window.parent.location) ? true : false;

alert(isInIFrame)
</script>-->
</html>
<script>
<?php if(isset($focus_field)):?>
$('#<?php echo $focus_field;?>').focus();
<?php endif;?>
</script>