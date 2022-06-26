<?php

$PRE = trim(ipsRegistry::dbFunctions()->getPrefix());

$QUERY[] = "DROP TABLE {$PRE}ep_blocks";
$QUERY[] = "DROP TABLE {$PRE}ep_pages";
