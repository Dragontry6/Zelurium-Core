<?php

namespace viskaraze\tasks;

use pocketmine\scheduler\Task;
use pocketmine\Server;

class nameTag extends Task
{
    public function onRun(): void
    {
        foreach(Server::getInstance()->getOnlinePlayers() as $player){
            $player->setNameTagVisible();
            $player->setNameTagVisible();
            $player->setScoreTag("§c " . $player->getHealth() . " ♥");
        }
    }
}