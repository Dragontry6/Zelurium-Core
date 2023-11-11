<?php

namespace viskaraze\forms;

use pocketmine\block\Air;
use pocketmine\item\Armor;
use pocketmine\item\Tool;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\Position;
use Vecnavium\FormsUI\SimpleForm;
use viskaraze\Manager;

class eventForm
{
    public static function eventForm(Player $player)
    {
        $form = new SimpleForm(function (Player $player, $data){
            if($data === null) {
                return true;
            }
            switch ($data){
                case 0;
                    if ($player instanceof Player) {
                        $world = Server::getInstance()->getWorldManager()->getWorldByName("spawn1");
                        $player->teleport(new Position(0, 0, 0, $world));
                    }
                break;
                case 1;
                    if ($player instanceof Player) {
                        $world = Server::getInstance()->getWorldManager()->getWorldByName("spawn1");
                        $player->teleport(new Position(1, 1, 1, $world));
                    }
                break;
                case 2;
                    if ($player instanceof Player) {
                        $world = Server::getInstance()->getWorldManager()->getWorldByName("spawn1");
                        $player->teleport(new Position(2, 2, 2, $world));
                    }
                break;
                case 3;
                    if ($player instanceof Player) {
                        $world = Server::getInstance()->getWorldManager()->getWorldByName("spawn1");
                        $player->teleport(new Position(3, 3, 3, $world));
                    }
                    break;
            }
        });

        $form->setTitle(Manager::flchMenu . "Events");
        $form->setContent("§7Où voulez vous aller ?");
        $form->addButton("§cKOTH");
        $form->addButton("§cNEXUS");
        $form->addButton("§cTOTEM");
        $form->addButton("§cOUTPOST");
        $player->sendForm($form);
    }
}