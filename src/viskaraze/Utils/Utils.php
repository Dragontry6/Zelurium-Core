<?php

namespace viskaraze\Utils;

use pocketmine\player\Player;

class Utils
{
    public static function isInPos(Player $player, string $posOne, string $posTwo, string $world) {

        $pos1 = explode(":", $posOne);
        $pos2 = explode(":", $posTwo);

        $minX = min($pos1[0], $pos2[0]);
        $maxX = max($pos1[0], $pos2[0]);
        $minY = min($pos1[1], $pos2[1]);
        $maxY = max($pos1[1], $pos2[1]);
        $minZ = min($pos1[2], $pos2[2]);
        $maxZ = max($pos1[2], $pos2[2]);

        if($player->getLocation()->x >= $minX && $player->getLocation()->x <= $maxX
            && $player->getLocation()->y >= $minY && $player->getLocation()->y <= $maxY
            && $player->getLocation()->z >= $minZ && $player->getLocation()->z <= $maxZ) {
            if($player->getWorld()->getFolderName() === $world){
                return true;
            } else return false;

        } else return false;
    }
}