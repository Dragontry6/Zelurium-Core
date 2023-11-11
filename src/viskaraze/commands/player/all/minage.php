<?php

namespace viskaraze\commands\player\all;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\Position;
use viskaraze\Manager;

class minage extends Command
{
    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("everyone");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player){
            $world = Server::getInstance()->getWorldManager()->getWorldByName("minage");
            $sender->teleport(new Position(0, 100,0, $world));
            $sender->sendMessage(Manager::Prefix . "Vous avez bien été téléporté au §6minage §7!");
        }

    }
}