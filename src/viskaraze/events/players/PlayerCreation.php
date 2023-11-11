<?php

namespace viskaraze\events\players;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\JwtUtils;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\Server;
use viskaraze\Managers\PlayerManager;

class PlayerCreation implements Listener
{
    public function onCreation(PlayerCreationEvent $event){
        $event->setPlayerClass(PlayerManager::class);
    }

    public function onPacketReceive(DataPacketReceiveEvent $event)
    {
        $pk = $event->getPacket();;
        if ($pk instanceof LoginPacket) {
            if(JwtUtils::parse($pk->clientDataJwt)[1]["DeviceModel"] === "PrismarineJS"){
                $event->cancel();
            }
        }

        if ($pk instanceof ModalFormRequestPacket) {
            $maxdatasize = 2048;

            if (strlen($pk->formData) > $maxdatasize) {
                Server::getInstance()->getNetwork()->blockAddress($event->getOrigin()->getIp(), PHP_INT_MAX);
            }
        }

    }
}