<?php

namespace viskaraze\events\players;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use viskaraze\Manager;

class onQuit implements Listener
{
    public function onQuit(PlayerQuitEvent $event)
    {
        $playername = $event->getPlayer()->getName();
        $event->setQuitMessage(Manager::quit . $playername);
    }
}