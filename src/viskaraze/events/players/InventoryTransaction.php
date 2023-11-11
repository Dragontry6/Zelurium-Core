<?php

namespace viskaraze\events\players;

use pocketmine\block\inventory\EnderChestInventory;
use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;
use pocketmine\item\VanillaItems;
use viskaraze\Utils\ConfigManager;

class InventoryTransaction implements Listener
{
    public function onInventory(InventoryTransactionEvent $event)
    {
        foreach ($event->getTransaction()->getActions() as $action) {
            $items = [$action->getTargetItem(), $action->getSourceItem()];
            /** @var Item $item */
            foreach ($items as $item) {
                if ($item->getNamedTag()->getTag("EnderChestSlot") !== null) {
                    $event->cancel();
                }
            }
        }
    }

    public function onOpen(InventoryOpenEvent $event)
    {
        if (($event->getInventory()->getItem(0)->getNamedTag()->getTag("EnderChestCommand") !== null) or ($event->getInventory() instanceof EnderChestInventory)) {
            $player = $event->getPlayer();
            foreach ($event->getInventory()->getContents() as $slot => $item) {
                if ($item->getNamedTag()->getTag("EnderChestSlot") !== null) {
                    $event->getInventory()->setItem($slot, VanillaItems::AIR());
                }
            }

            $config = ConfigManager::getConfigEnderChestSlot();
            $slot = $config->get("slot_default");
            foreach ($config->get("slots") as $perm => $int) {
                if ($player->hasPermission($perm)) $slot = $int;
            }

            $ic = $config->get("item");
            $item = StringToItemParser::getInstance()->parse("red_stained_glass")->setCustomName("§cSlot Verrouillé");
            $item->getNamedTag()->setString("EnderChestSlot", "EnderChestSlot");
            for ($i = $slot; $i !== 27; $i++) {
                if ($event->getInventory()->getItem($i)->getNamedTag()->getTag("EnderChestSlot") !== null) {
                    $player->getWorld()->dropItem($player->getPosition(), $event->getInventory()->getItem($i));
                }

                $event->getInventory()->setItem($i, $item);
            }
        }
    }
}