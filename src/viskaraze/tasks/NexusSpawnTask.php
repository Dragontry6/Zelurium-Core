<?php

namespace viskaraze\tasks;

use viskaraze\Entity\NexusEntity;
use pocketmine\console\ConsoleCommandSender;
use pocketmine\entity\Location;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use viskaraze\zCore;
use viskaraze\Manager;

class NexusSpawnTask extends Task{

    public function onRun(): void{

        $coord = explode(":", zCore::getInstance()->getConfig()->getNested("Nexus-Settings.AutoSpawn.position"));
        Server::getInstance()->getWorldManager()->loadWorld($coord[3]);
        foreach(Server::getInstance()->getWorldManager()->getWorlds() as $world){
            foreach($world->getEntities() as $entity){
                if($entity instanceof NexusEntity){
                    $entity->kill();
                }
            }
        }
        $entity = new NexusEntity(new Location((int)$coord[0], (int)$coord[1], (int)$coord[2], Server::getInstance()->getWorldManager()->getWorldByName($coord[3]), 0, 0));
        $entity->spawnToAll();

        Server::getInstance()->broadcastMessage(Manager::Prefix . "Un §6Nexus vient de spawn !");
    }
}

