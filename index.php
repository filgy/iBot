#!/usr/bin/php

<?php

	require "./lib/iLoader.php";
	
	iLoader::init();

	$iBot = new iCore();
	$iBot->addServer("Quakenet", "irc.quakenet.org", 6667)
		->joinChannel("#wowresource")
		->joinChannel("#wowresourcedev");
		
	$iBot->addServer("IRCnet", "irc.gts.cz", 6667);
	$iBot->joinChannel("IRCnet", "#fit");
		
	var_dump($iBot);
	
//	$iBot->run();
