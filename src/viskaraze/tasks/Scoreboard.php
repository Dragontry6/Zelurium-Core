<?php

namespace viskaraze\tasks;


use pocketmine\scheduler\Task;
use pocketmine\Server;
use viskaraze\Managers\PlayerManager;

class Scoreboard extends Task
{
    public static $scoreboard = [];
    public function onRun(): void
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
                $player->sendScoreboard();
        }
    }
}