<?php

namespace viskaraze\events\players;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\player\Player;
use viskaraze\zCore;

class onDamage implements Listener
{
    public function onDamage(EntityDamageEvent $event)
    {

        $player = $event->getEntity();
        $cause = $event->getCause();

        if (!$player instanceof Player) return true;
        if ($cause !== EntityDamageEvent::CAUSE_VOID) return true;

        $player->teleport(zCore::getInstance()->getServer()->getWorldManager()->getDefaultWorld()->getSpawnLocation());
        $event->cancel();

    }
}