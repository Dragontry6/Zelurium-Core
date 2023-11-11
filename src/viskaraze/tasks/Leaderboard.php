<?php

namespace viskaraze\tasks;

use pocketmine\scheduler\Task;
use viskaraze\API\LeaderboardAPI;
use viskaraze\Entity\TopDeaths;
use viskaraze\Entity\TopFaction;
use viskaraze\Entity\TopKills;
use viskaraze\Entity\TopMoney;
use viskaraze\events\players\onDeath;
use viskaraze\Utils\ConfigManager;

class Leaderboard extends Task
{
    private TopKills $topKills;
    private TopDeaths $topDeaths;

    public function __construct(TopDeaths $topDeaths, TopKills $topKills, TopMoney $topMoney, TopFaction $topFaction) {
        $this->topDeaths = $topDeaths;
        $this->topKills = $topKills;
        $this->topMoney = $topMoney;
        $this->topFaction = $topFaction;
    }
    public function onRun(): void
    {
        $configdeaths = ConfigManager::getPlayerDeaths();
        $configkills = ConfigManager::getPlayerKills();

        $topDeaths = onDeath::getTopDeaths($configdeaths);
        $topKills = onDeath::getTopKills($configkills);

        $this->topDeaths->setNameTag("§f=== §cTop Morts §f=== \n" . implode("\n", $topDeaths));
        $this->topKills->setNameTag("§f=== §aTop Kills §f=== \n" . implode("\n", $topKills));
        $this->topMoney->setNameTag(LeaderboardAPI::getTopMoney());
        $this->topFaction->setNameTag(LeaderboardAPI::getFactionTop());


    }
}