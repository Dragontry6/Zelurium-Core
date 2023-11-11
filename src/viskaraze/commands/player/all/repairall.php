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

class repairall extends Command
{
    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("everyone");
    }

    private array $players = [];

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $time_all = null;
        foreach ($sender->getEffectivePermissions() as $permission) {
            if (explode(".", $permission->getPermission())[0] === "repairall") {
                if (is_numeric(explode(".", $permission->getPermission())[1])) {
                    $time_all = explode(".", $permission->getPermission())[1];
                    break;
                }
            }
        }

        if (!is_null($time_all)) {
            foreach ($sender->getInventory()->getContents() as $slot => $item) {
                $this->repairItem($item, $slot, $sender);
            }
            $sender->sendMessage(Manager::Prefix . "Tout votre inventaire à été réparé !");
            $this->players[$sender->getName()] = $time_all + time();
        } $sender->sendMessage(Manager::noPerm);

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