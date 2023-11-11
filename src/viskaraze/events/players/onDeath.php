<?php

namespace viskaraze\events\players;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\player\Player;
use viskaraze\zCore;
use viskaraze\Manager;
use viskaraze\Utils\ConfigManager;

class onDeath implements Listener
{

    public function onDeath(PlayerDeathEvent $event)
    {

        /*
         * Message de kills
         */

        if ($event->getPlayer() instanceof Player) { $player = $event->getPlayer(); $cause = $event->getEntity()->getLastDamageCause(); if ($cause instanceof EntityDamageEvent) { $message = $this->getDeathMessage($cause); if ($message !== null) { $message = str_replace("{player}", $player->getName(), $message); $event->setDeathMessage($message); } } }

        /*
        * LEADEBOARD DEATHS
        */
        $playername = $event->getPlayer()->getName();
        $config = ConfigManager::getPlayerDeaths();
        $playerList = $config->get("players", []);

        if (in_array($playername, $playerList)) {
            $deaths = $config->get("deaths", []);
            $deaths[$playername] = isset($deaths[$playername]) ? $deaths[$playername] + 1 : 1;
            $config->set("deaths", $deaths);
        } else {
            $playerList[] = $playername;
            $config->set("players", $playerList);

            $deaths = $config->get("deaths", []);
            $deaths[$playername] = 1;
            $config->set("deaths", $deaths);
        }
        $config->save();

        /*
         * LEADEARBOARD KILLS
         */

        if ($event->getPlayer()->getLastDamageCause() instanceof EntityDamageByEntityEvent) {
            if ($event->getPlayer()->getLastDamageCause()->getDamager() instanceof Player) {
                $playernameKiller = $event->getPlayer()->getLastDamageCause()->getDamager()->getName();
                $config1 = ConfigManager::getPlayerKills();
                $playerList = $config1->get("players", []);

                if (in_array($playernameKiller, $playerList)) {
                    $kills = $config1->get("kills", []);
                    $kills[$playernameKiller] = isset($kills[$playernameKiller]) ? $kills[$playernameKiller] + 1 : 1;
                    $config1->set("kills", $kills);
                } else {
                    $playerList[] = $playernameKiller;
                    $config1->set("players", $playerList);

                    $kills = $config1->get("kills", []);
                    $kills[$playernameKiller] = 1;
                    $config1->set("kills", $kills);
                }
                $config1->save();
            }
        }
    }

    private function getDeathMessage(EntityDamageEvent $cause): ?string {

        switch ($cause->getCause()) {
            case EntityDamageEvent::CAUSE_ENTITY_ATTACK:
                if ($cause instanceof EntityDamageByEntityEvent) {
                    $damager = $cause->getDamager();
                    if ($damager !== null) {
                        return Manager::flchMenu . "§6" . $cause->getDamager() . "§7 a tué §6 {player}";
                    }
                }
                break;
        }
        return null;
    }

    public static function getTopDeaths($config) {
        $deaths = $config->get("deaths", []);

        // Trie le tableau des morts dans l'ordre décroissant
        arsort($deaths);

        $topDeaths = [];
        $position = 1;

        foreach ($deaths as $playername => $deathCount) {
            $topDeaths[] = "§c" . $position . "§f- §c" . $playername . "§f - §c" . $deathCount . " morts";
            $position++;

            // Sort de la boucle si on a atteint le top 5
            if ($position > 5) {
                break;
            }
        }

        return $topDeaths;
    }

    public static function getTopKills($config) {
        $kills = $config->get("kills", []);

        // Trie le tableau des morts dans l'ordre décroissant
        arsort($kills);

        $topKills = [];
        $position = 1;

        foreach ($kills as $playername => $deathCount) {
            $topKills[] = "§a" . $position . "§f- §a" . $playername . "§f - §a" . $deathCount . " kills";
            $position++;

            // Sort de la boucle si on a atteint le top 5
            if ($position > 5) {
                break;
            }
        }

        return $topKills;
    }
}