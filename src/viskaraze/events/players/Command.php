<?php

namespace viskaraze\events\players;

use pocketmine\event\Listener;
use pocketmine\event\server\CommandEvent;
use viskaraze\Manager;

class Command implements Listener
{
    public function RemoveSpaceCommand(CommandEvent $event) {

        $message = $event->getCommand();
        $sender = $event->getSender();
        /**
         * logs
         */



        $msg = explode(' ', trim($message));
        $m = substr($message, 0, 1);
        $whitespace_check = substr($message, 0, 1);
        $slash_check = substr($msg[0], -1, 1);
        $quote_mark_check = substr($message, 0, 1) . substr($message, -1, 1);

        if ($whitespace_check === ' ' || $whitespace_check === '\\' || $slash_check === '\\' || $quote_mark_check === '""') {
            $event->cancel();
            $sender->sendMessage(Manager::ErrorPrefix . "Tu ne peux pas mettre d'espace !");
        }
    }
}