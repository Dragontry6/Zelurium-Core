<?php

namespace viskaraze\commands\admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use viskaraze\forms\shopForm;
use viskaraze\Manager;

class addshop extends Command
{
    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("shop.add");
        $this->setPermissionMessage(Manager::Prefix . " Tu n'as pas la permission de faire ceci !");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        shopForm::addItemInShop($sender);
    }

}