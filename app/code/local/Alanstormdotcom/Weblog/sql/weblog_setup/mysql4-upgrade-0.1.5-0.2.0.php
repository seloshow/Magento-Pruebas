<?php
//echo 'Testing our upgrade script (mysql4-upgrade-0.1.0-0.2.0.php) and halting execution to avoid updating the system version number <br />';
//die();
$installer = $this;
$installer->startSetup();
$installer->run("
    ALTER TABLE `{$installer->getTable('weblog/blogpost')}`
    CHANGE post post text not null;
");
$installer->endSetup();
//die("You'll see why this is here in a second");