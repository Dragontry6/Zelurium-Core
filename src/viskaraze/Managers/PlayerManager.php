<?php
namespace viskaraze\Managers;

use DaPigGuy\PiggyFactions\PiggyFactions;
use onebone\economyapi\EconomyAPI;
use pocketmine\player\Player;
use viskaraze\zCore;
use viskaraze\Managers\ScoreboardManager;

class PlayerManager extends Player
{
    public function sendScoreboard(){
        $scoreboard = new ScoreboardManager($this);

        $allPlayer = count($this->getServer()->getOnlinePlayers());
        $maxPlayer = $this->getServer()->getMaxPlayers();
        $moneyOfPlayer = EconomyAPI::getInstance()->myMoney($this);
        $scoreboard->addScoreboard("  ");
        $scoreboard->setLine(0, "   ");
        $scoreboard->setLine(1, "    ");
        $scoreboard->setLine(2, "     ");
        $scoreboard->setLine(4, " §6§l» §r§7" . $this->getName());
        $scoreboard->setLine(5, " §7Argent: §6$moneyOfPlayer$");
        $playerFaction = PiggyFactions::getInstance()->getPlayerManager()->getPlayer($this);
        if($playerFaction === null) {
            $scoreboard->setLine(6, " §7Faction: §6...");
        } else {
            if($playerFaction->getFaction() === null)
            {
                 $scoreboard->setLine(6, " §7Faction: §6...");
            } else {
                $factionName = $playerFaction->getFaction()->getName();
                $scoreboard->setLine(6, " §7Faction: §6$factionName");
            }
        }
        $scoreboard->setLine(7, " §6§l» §r§7Serveur §r§7[§6" . $allPlayer . "§7]");
        $scoreboard->setLine(8, " §7VoteParty: §6" . zCore::$voteParty->getNumberVoteParty() . "§7/§625");
        $scoreboard->setLine(9, " §7-----------");
        $scoreboard->setLine(10, " §6zelurium.fr");
    }
}