<?php

namespace viskaraze\commands\player\all;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use viskaraze\forms\KitForms;
use viskaraze\Utils\ConfigManager;

class kits extends Command
{
    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("everyone");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            if ((isset($args[0])) and ($args[0] === "add")) {
          //   if ($sender->hasPermission("kit.add") {
                    KitForms::addKitForm($sender);
               // } else $sender->sendMessage("no perm");
            } elseif ((isset($args[0])) and $args[0] === "remove") {
                if ($sender->hasPermission(ConfigManager::getConfigKits()->get("permission_add"))) {
                    if (isset($args[1])) {
                        if (ConfigManager::getConfigKits()->getNested("kits.$args[1]") !== null) {
                            ConfigManager::getConfigKits()->removeNested("kits.$args[1]");
                            ConfigManager::getConfigKits()->save();
                            $sender->sendMessage(str_replace("{kit}", $args[1], ConfigManager::getConfigKits()->get("remove_kit")));
                        } else $sender->sendMessage(ConfigManager::getConfigKits()->get("no_exist"));
                    } else $sender->sendMessage(ConfigManager::getConfigKits()->get("no_kit"));
                } else $sender->sendMessage(ConfigManager::getConfigKits()->get("no_perm"));
            } else {
                if (empty(ConfigManager::getConfigKits()->get("category"))) {
                    KitForms::listKit($sender);
                } else KitForms::listCategory($sender);
            }
        } else $sender->sendMessage(ConfigManager::getConfigKits()->get("no_player"));
    }

}