<?php

namespace viskaraze\protection;

use pocketmine\block\Block;
use viskaraze\protection\events\EventsProtections;
use pocketmine\entity\Entity;
use viskaraze\zCore;

class Protection
{
    public static function startProtection(){
        zCore::getInstance()->getServer()->getPluginManager()->registerEvents(new EventsProtections(), zCore::getInstance());
    }

    public static function blockIsInZonePlace($blocks, $posOne, $posTwo, $player, $world){
        $pos1 = explode(":", $posOne);
        $pos2 = explode(":", $posTwo);

        $minX = min($pos1[0], $pos2[0]);
        $maxX = max($pos1[0], $pos2[0]);
        $minY = min($pos1[1], $pos2[1]);
        $maxY = max($pos1[1], $pos2[1]);
        $minZ = min($pos1[2], $pos2[2]);
        $maxZ = max($pos1[2], $pos2[2]);

        foreach ($blocks as [$x, $y, $z, $block]) {
            if ($block->getPosition()->x >= $minX && $block->getPosition()->x <= $maxX && $block->getPosition()->z >= $minZ && $block->getPosition()->z <= $maxZ) {
                if ($player->getWorld()->getFolderName() === $world) {
                    return true;
                } else return false;

            } else return false;
        }
    }

    public static function blockIsInZoneBreak($blocks, $posOne, $posTwo, $player, $world){
        $pos1 = explode(":", $posOne);
        $pos2 = explode(":", $posTwo);

        $minX = min($pos1[0], $pos2[0]);
        $maxX = max($pos1[0], $pos2[0]);
        $minY = min($pos1[1], $pos2[1]);
        $maxY = max($pos1[1], $pos2[1]);
        $minZ = min($pos1[2], $pos2[2]);
        $maxZ = max($pos1[2], $pos2[2]);

            if ($blocks->getPosition()->x >= $minX && $blocks->getPosition()->x <= $maxX && $blocks->getPosition()->z >= $minZ && $blocks->getPosition()->z <= $maxZ) {
                if ($player->getWorld()->getFolderName() === $world) {
                    return true;
                } else return false;

            } else return false;
    }

    public static function entityIsInZone(Entity $entity, string $posOne, string $posTwo, string $world) {

        $pos1 = explode(":", $posOne);
        $pos2 = explode(":", $posTwo);

        $minX = min($pos1[0], $pos2[0]);
        $maxX = max($pos1[0], $pos2[0]);
        $minY = min($pos1[1], $pos2[1]);
        $maxY = max($pos1[1], $pos2[1]);
        $minZ = min($pos1[2], $pos2[2]);
        $maxZ = max($pos1[2], $pos2[2]);

        if($entity->getLocation()->x >= $minX && $entity->getLocation()->x <= $maxX && $entity->getLocation()->z >= $minZ && $entity->getLocation()->z <= $maxZ) {
            if($entity->getWorld()->getFolderName() === $world){
                return true;
            } else return false;

        } else return false;
    }
}