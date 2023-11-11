<?php

namespace viskaraze\events\players;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;
use viskaraze\zCore;
use viskaraze\Manager;
use viskaraze\Utils\ConfigManager;
use pocketmine\network\mcpe\protocol\GameRulesChangedPacket;
use pocketmine\network\mcpe\protocol\types\BoolGameRule;
use function pocketmine\server;

class onJoin implements Listener
{
    public function onJoin(PlayerJoinEvent $event)
    {
        $playername = $event->getPlayer()->getName();
        $event->setJoinMessage(Manager::join . $playername);
        $event->getPlayer()->sendToastNotification("§6Bienvenue", "§aBon jeu sur notre serveur !");
        $player = $event->getPlayer();
        $pk = new GameRulesChangedPacket();
        $pk->gameRules = ["showcoordinates" =>  new BoolGameRule(true, true)];
        $event->getPlayer()->getNetworkSession()->sendDataPacket($pk);

        // logsAPI::onJoinLogs($event->getPlayer());

        $config = ConfigManager::getPlayerJoinJson();
        $playerList = $config->get("players", []);

        if (in_array($playername, $playerList)) {

        } else {
            $NumberAllOfPlayers = count($playerList);
            $playerList[] = $playername;
            zCore::getInstance()->getServer()->broadcastMessage(Manager::Prefix . "Bienvenue à §6@$playername §7qui se connecte pour la première fois ! (§6#" . $NumberAllOfPlayers . "§7)");
            $config->set("players", $playerList);
            $config->save();
        }
    }

}