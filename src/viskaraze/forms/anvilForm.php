<?php

namespace viskaraze\forms;

use pocketmine\block\Air;
use pocketmine\item\Armor;
use pocketmine\item\Tool;
use pocketmine\player\Player;
use Vecnavium\FormsUI\SimpleForm;
use viskaraze\Manager;

class anvilForm
{
    public static function anvilForm(Player $player)
    {
        $form = new SimpleForm(function (Player $player, $data){
            if($data === null) {
                return true;
            }
            switch ($data){
                case 0;
                if($player instanceof Player) {
                    if($player->getXpManager()->getXpLevel() >= 10) {
                        if ($player->getInventory()->getItemInHand() instanceof Armor || $player->getInventory()->getItemInHand() instanceof Tool) {
                            if (!$player->getInventory()->getItemInHand() instanceof Air) {
                                $item = $player->getInventory()->getItemInHand();
                                $item->setDamage(0);
                                $player->getXpManager()->subtractXpLevels(10);
                                if (!$player->getInventory()->getItemInHand() instanceof Air) {
                                    $player->getInventory()->setItemInHand($item);
                                    $player->sendMessage(Manager::Prefix . "Votre item a bien été réparer !");
                                } else {
                                    $player->sendPopup(Manager::ErrorPrefix . "Duppli interdite");
                                }
                            } else {
                                $player->sendMessage(Manager::ErrorPrefix . "Vous n'avez pas d'item dans votre main !");
                            }
                        } else {
                            $player->sendMessage(Manager::ErrorPrefix . "Cet item ne peut être réparer !");
                        }
                    } else {
                        $player->sendMessage(Manager::ErrorPrefix . "Vous n'avez pas assez d'xp sur vous ! Vous devez avoir 10 niveaux !");
                    }
                }
                break;
                case 1;
                    $player->sendMessage();
                break;
            }
        });

        $form->setTitle(Manager::flchMenu . "Enclume");
        $form->setContent("Bonjour @" . $player->getName(). " ! Que voulez vous faire ?");
        $form->addButton("§cRéparer");
        $form->addButton("§aRename");
        $player->sendForm($form);
    }
}