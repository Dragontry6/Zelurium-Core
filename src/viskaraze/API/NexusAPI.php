<?php

namespace viskaraze\API;

use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\world\World;
use viskaraze\Entity\NexusEntity;

class NexusAPI
{
    public static function registerNexus(){
        EntityFactory::getInstance()->register(NexusEntity::class, function(World $world, CompoundTag $nbt): NexusEntity{
            return new NexusEntity(EntityDataHelper::parseLocation($nbt, $world), $nbt);
        }, ["nexus_event", "minecraft:event_nexus"]);
    }
}