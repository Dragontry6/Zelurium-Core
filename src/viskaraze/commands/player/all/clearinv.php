<?php

namespace viskaraze\commands\player\all;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use viskaraze\Manager;

class clearinv extends Command
{
    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("everyone");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            $sender->getInventory()->clearAll();
            $sender->getArmorInventory()->clearAll();
            $sender->sendToastNotification(Manager::Prefix, "§aVous avez bien vidé votre inventaire et armure !");
        }
    }
}