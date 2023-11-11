<?php

namespace viskaraze\commands\player\all;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\world\Position;
use viskaraze\zCore;
use viskaraze\Manager;

class spawn extends Command
{
    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("everyone");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $worldConfig = "spawn1";
        $world = zCore::getInstance()->getServer()->getWorldManager()->getWorldByName($worldConfig);
        $sender->teleport(new Position(-24, 85, -8, $world));
        $sender->sendMessage(Manager::Prefix . "Vous êtes désormais au spawn !");
    }

}