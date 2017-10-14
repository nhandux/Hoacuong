<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }

?>
<li>
	<a href="<?php echo HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row2['gallery_menu_id'], 'gallery') . '/' .  $stringObj->getLinkHtml($row2['name'], $row2['gallery_id'])?>" title="<?php echo stripslashes($row2['name']); ?>" ><?php echo stripslashes($row2['name']); ?></a>
</li>