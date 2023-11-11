<?php

namespace viskaraze\API;

use DaPigGuy\PiggyFactions\factions\Faction;
use DaPigGuy\PiggyFactions\flags\Flag;
use DaPigGuy\PiggyFactions\PiggyFactions;
use DaPigGuy\PiggyFactions\utils\RoundValue;
use onebone\economyapi\EconomyAPI;

class LeaderboardAPI
{
    public static function getAllMoney() :array
    {
        $all = EconomyAPI::getInstance()->getAllMoney();

        return $all;
    }

    public static function getTopMoney(): string
    {
        $allMoney = self::getAllMoney();
        arsort($allMoney); // Trie le tableau en ordre décroissant selon les valeurs

        $topMoney = array_slice($allMoney, 0, 10, true); // Récupère les 10 premières entrées du tableau

        $output = "§f=== §eTop Money §f===\n";
        $rank = 1;
        foreach ($topMoney as $username => $amount) {
            $output .= "§e" . $rank . "§f- §e" . $username . " §favec §e" . $amount . "$ §r\n";
            $rank++;
        }

        return $output;
    }


    public static function getFactionTop(): string
    {
        $types = [
            "power" => function (Faction $a, Faction $b): int {
                return (int)($b->getPower() - $a->getPower());
            }
        ];

        $plugin = PiggyFactions::getInstance();
        if (!$plugin->isEnabled()) {
            return ""; // Le plugin n'est pas activé ou chargé, renvoie une chaîne vide
        }

        $factionsManager = $plugin->getFactionsManager();
        if ($factionsManager === null) {
            return ""; // Le gestionnaire de factions n'est pas disponible, renvoie une chaîne vide
        }

        $factions = array_filter($factionsManager->getFactions(), function (Faction $faction): bool {
            return !$faction->getFlag(Flag::SAFEZONE) && !$faction->getFlag(Flag::WARZONE);
        });
        usort($factions, $types["power"]);

        $topFactions = array_slice($factions, 0, 10); // Récupère les 10 premières factions

        $leaderboard = "§f=== §6Top Faction §f=== \n";
        foreach ($topFactions as $rank => $faction) {
            $leaderboard .= '§6' . ($rank + 1) . "§f- §6" . $faction->getName() . "§f - §6Power: " . RoundValue::round($faction->getPower()) . "\n";
        }

        return $leaderboard;
    }

}