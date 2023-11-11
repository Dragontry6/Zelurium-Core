<?php

namespace viskaraze\Entity;

use pocketmine\event\entity\EntityMotionEvent;
use pocketmine\event\Listener;
use viskaraze\Entity\NexusEntity;

class EntityMove implements Listener {

    public function onMove(EntityMotionEvent $event){
        if($event->getEntity() instanceof NexusEntity){
            $event->cancel();
        }
    }
}
