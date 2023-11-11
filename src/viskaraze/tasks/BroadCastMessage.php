<?php

namespace viskaraze\tasks;

use pocketmine\scheduler\Task;
use viskaraze\zCore;
use viskaraze\Manager;

class BroadCastMessage extends Task
{

    public static $counter = 0;
    public static $time = 0;
    public static $messages = [Manager::flchPrefix . "§cBon jeu sur Zélurium !", Manager::flchPrefix . "N'hésitez pas à rejoindre notre discord : discord.gg/8cspE28Kvb", Manager::flchPrefix . "Un problème ? Une suggestion ? Ouvre un ticket sur le discord !", Manager::flchPrefix . "Tu souhaites acheter un grade ? C'est par ici : zelurium-network.tebex.io/", Manager::flchPrefix . "N'oublie pas qu'en jouant sur le serveur, tu acceptes les règles ! Si tu ne les respectes pas, tu seras sanctionné(e)"];

        public function onRun(): void{

        if(self::$time === 500){
            $serv = zCore::getInstance()->getServer();

            $serv->broadcastMessage(self::$messages[self::$counter]);

            self::$counter++;
            if(self::$counter == count(self::$messages)){
                self::$counter = 0;
            }
            self::$time = 0;

        }
        self::$time++;
    }
}