<?php

namespace viskaraze\tasks;

use Outpost\OutpostEntity;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\network\mcpe\protocol\types\EducationSettingsExternalLinkSettings;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\world\sound\EntityLandSound;
use viskaraze\Entity\NexusEntity;
use viskaraze\Entity\TopDeaths;
use viskaraze\Entity\TopFaction;
use viskaraze\Entity\TopKills;
use viskaraze\Entity\TopMoney;
use viskaraze\Manager;

class ClearLag extends Task
{
    public static int $time = 120;
    public function onRun(): void
    {
        --self::$time;
        if (self::$time <= 0) {
            $count = 0;
            foreach (Server::getInstance()->getWorldManager()->getWorlds() as $world) {
                foreach ($world->getEntities() as $entity) {
                    if (!$entity instanceof Player) {
                        if($entity instanceof TopDeaths) {
                        } else if ($entity instanceof  TopKills) {
                        } else if ($entity instanceof TopMoney) {
                        } else if ($entity instanceof TopFaction) {
                        } else if ($entity instanceof OutpostEntity) {
                        } else if ($entity instanceof NexusEntity) {
                        } else if ($entity instanceof OutpostEntity) {
                        } else {
                            $entity->flagForDespawn();
                            $count++;
                        }
                    }
                }
            }
            foreach (Server::getInstance()->getOnlinePlayers() as $player) {
                $player->sendPopup(Manager::Prefix ."§6".$count. " §7entitées ont été supprimées");
            }
            self::$time = 120;
            $count = 0;
        } elseif (in_array(self::$time, ([1, 2, 3, 4, 5, 10, 15, 30, 60]))) {
            foreach (Server::getInstance()->getOnlinePlayers() as $player) {
                $player->sendPopup("§6- §7Les entitées seront supprimées dans §6". self::$time . " §7seconde(s) §6-");
            }
        }
    }
}