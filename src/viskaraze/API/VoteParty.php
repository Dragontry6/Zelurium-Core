<?php

namespace viskaraze\API;

use pocketmine\console\ConsoleCommandSender;
use pocketmine\player\Player;
use viskaraze\zCore;
use viskaraze\Manager;
use viskaraze\Utils\ConfigManager;

class VoteParty
{
    public function getNumberVoteParty() :int
    {
       $config = ConfigManager::getVoteParty();

       return $config->get("AllVote");
    }

    public function resetVoteParty() :void
    {
        $config = ConfigManager::getVoteParty();
        $config->set("AllVote", 0);
        $config->save();
    }

    public function addVoteParty() :void
    {
        $config = ConfigManager::getVoteParty();
        if ($config->exists("AllVote")){
            $config->set("AllVote", $this->getNumberVoteParty() + 1);
            $config->save();
            if ($this->getNumberVoteParty() >= 25){
                $players = zCore::getInstance()->getServer()->getOnlinePlayers();
                foreach ($players as $player) {
                    zCore::getInstance()->getServer()->dispatchCommand(new ConsoleCommandSender(zCore::getInstance()->getServer(), zCore::getInstance()->getServer()->getLanguage()), "say " .Manager::Prefix . "Nous sommes arrivé à l'objectif du VoteParty ! Vous avez Tous reçu votre récompense!");
                }
                $this->resetVoteParty();
            }
        } else {
            $config->set("AllVote", 1);
            $config->save();
        }
    }

}