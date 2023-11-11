<?php

namespace viskaraze\commands\player\all;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\world\Position;
use viskaraze\zCore;
use viskaraze\Manager;
use viskaraze\forms\anvilForm;

class repair extends Command
{
    private array $players = [];

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("everyone");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $time = null;
        foreach ($sender->getEffectivePermissions() as $permission) {
            if (explode(".", $permission->getPermission())[0] === "repair") {
                if (is_numeric(explode(".", $permission->getPermission())[1])) {
                    $time = explode(".", $permission->getPermission())[1];
                    break;
                }
            }
        }
            if (!is_null($time)) {
                if (!(isset($this->players[$sender->getName()])) or ($this->players[$sender->getName()] < time())) {
                    if ($this->repairItem($sender->getInventory()->getItemInHand(), 0, $sender, true)) {
                        $sender->sendMessage(Manager::Prefix . "Votre item à bien été réparer !");
                        $this->players[$sender->getName()] = $time + time();
                    } else $sender->sendMessage(Manager::ErrorPrefix . "Vous ne pouvez pas réparer ceci !");
                } else $sender->sendMessage(Manager::ErrorPrefix . "Vous devez encore attendre avant de faire ça !");
            } else $sender->sendMessage(Manager::noPerm);

    }

    public function repairItem(Item $item, int $slot, Player $player, bool $inHand = false): bool
    {
        if (($item instanceof Tool) or ($item instanceof Armor)) {
            if ($item->getDamage() > 0) {
                $item->setDamage(0);
                if ($item->getNamedTag()->getTag("Durabilité") !== null) $item->getNamedTag()->setString("Durabilité", $item->getMaxDurability());
                $inHand ? $player->getInventory()->setItemInHand($item) : $player->getInventory()->setItem($slot, $item);
                return true;
            } else return false;
        } else return false;
    }

}