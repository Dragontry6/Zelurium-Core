<?php

namespace viskaraze\events\players;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerExhaustEvent;

class onExhaust implements Listener
{
    public function onExhaust(PlayerExhaustEvent $event)
    {
        $event->cancel();
    }
}