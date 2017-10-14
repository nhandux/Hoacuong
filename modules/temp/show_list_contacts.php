<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//-----------------
?>

<div class="contacts">
	<div class="reveal"></div>
	<div class="title"><?php echo stripslashes($row['name']);?></div>
	<div class="post animated clearfix">
		<?php echo stripslashes($row['content']);?>
	</div>
</div>