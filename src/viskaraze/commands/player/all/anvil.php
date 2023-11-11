<?php

namespace viskaraze\commands\player\all;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\world\Position;
use viskaraze\zCore;
use viskaraze\Manager;
use viskaraze\forms\anvilForm;

class anvil extends Command
{
    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("everyone");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        anvilForm::anvilForm($sender);
    }

}