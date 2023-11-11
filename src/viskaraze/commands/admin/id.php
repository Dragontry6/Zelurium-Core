<?php

namespace viskaraze\commands\admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\StringToItemParser;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use viskaraze\forms\shopForm;
use viskaraze\Manager;

class id extends Command
{
    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("everyone");
        $this->setPermissionMessage(Manager::Prefix . " Tu n'as pas la permission de faire ceci !");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
           $itemname = StringToItemParser::getInstance()->lookupAliases($sender->getInventory()->getItemInHand());
           var_dump($itemname);
           $sender->sendMessage("ID : " . $itemname[0]);
        }
    }

}