<?php
namespace viskaraze\protection\events;

use pocketmine\block\Block;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\player\Player;
use pocketmine\Server;
use viskaraze\events\players\onDamage;
use viskaraze\Manager;
use viskaraze\protection\Protection;
use viskaraze\Utils\Utils;

class EventsProtections implements Listener
{
        public function onDamage(EntityDamageByEntityEvent $event){
            if ($event->getDamager() instanceof Player) {
                if (!$event->getDamager()->hasPermission("op")) {
                    $player = $event->getEntity();
                    $damager = $event->getDamager();
                    if (!$player instanceof Player) return;

                    if (Utils::isInPos($player, "-76:66:-75", "74:255:75", "KITMAP")) {
                        $player->sendMessage(Manager::ErrorPrefix . "Vous ne pouvez pas faire ca ici !");
                        $event->cancel();
                        return true;
                    }

                    if (Protection::entityIsInZone($damager, "191:0:191", "-192:0:-192", "KITMAP")) {
                        $event->uncancel();
                        return true;
                    }

                    if ($event->getEntity()->getWorld()->getDisplayName() === "afk") {
                        $event->cancel();
                    }
                }
            }
    }


    public function BBE(BlockBreakEvent $event)
    {
        if (!$event->getPlayer()->hasPermission("op")) {
            $player = $event->getPlayer();
            $block = $event->getBlock();
            $world = $player->getWorld()->getFolderName();

            if (Protection::blockIsInZoneBreak($block, "-100:0:100", "100:999:-100", $player, "spawn1")) {
                if (!$player->getServer()->isOp($player->getName())) {
                    $player->sendMessage(Manager::ErrorPrefix . "Vous ne pouvez pas faire ca ici !");
                    $event->cancel();
                }
            }
            if ($event->getBlock()->getPosition()->getWorld()->getDisplayName() === "afk") {
                $event->cancel();
            }
        }
    }


    public function BPE(BlockPlaceEvent $event)
    {
        if (!$event->getPlayer()->hasPermission("op")) {
            $player = $event->getPlayer();
            $block = $event->getTransaction()->getBlocks();
            $world = $player->getWorld()->getFolderName();

            if (Protection::blockIsInZonePlace($block, "159:0:159", "-160:999:-160", $player, "spawn")) {
                if (!$player->getServer()->isOp($player->getName())) {
                    $player->sendMessage(Manager::ErrorPrefix . "Vous ne pouvez pas faire ca ici !");
                    $event->cancel();
                }
            }
            foreach ($event->getTransaction()->getBlocks() as [$x, $y, $z, $block]) {
                if ($block instanceof Block) {
                    if ($block->getPosition()->getWorld()->getDisplayName() === "afk") {
                        $event->cancel();
                    }
                }
            }
        }
    }

    public function onInteract(PlayerInteractEvent $event){
            if (!$event->getPlayer()->hasPermission("op")) {
                if ($event->getPlayer()->getPosition()->getWorld()->getDisplayName() === "afk") {
                    $event->cancel();
                }
            }
    }
}
