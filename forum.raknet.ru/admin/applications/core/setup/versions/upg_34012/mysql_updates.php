<?php

$PRE = trim(ipsRegistry::dbFunctions()->getPrefix());
$DB  = ipsRegistry::DB();

$SQL[] = "DELETE FROM core_sys_conf_settings WHERE conf_key IN('sl_publicdata','ipb_prune_email');";
$SQL[] = "ALTER TABLE reputation_totals ADD INDEX ( rt_type_id );";