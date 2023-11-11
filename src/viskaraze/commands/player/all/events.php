<?php

namespace viskaraze\commands\player\all;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\Position;
use Vecnavium\FormsUI\SimpleForm;
use viskaraze\Manager;

class events extends Command
{
    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("everyone");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
       $form = new SimpleForm(function (Player $sender, $data){

            if ($data === null) {
                return true;
            }
        switch ($data){
            case 0:
                $sender->teleport(new Position(1, 1, 1, Server::getInstance()->getWorldManager()->getWorldByName("world")));
                $sender->sendMessage(Manager::Prefix . "Vous avez bien été téléporté au §6Nexus !");
                break;
            case 1:
                $sender->teleport(new Position(1, 1, 1, Server::getInstance()->getWorldManager()->getWorldByName("world")));
                $sender->sendMessage(Manager::Prefix . "Vous avez bien été téléporté au §6Koth !");
                break;
            case 2:
                $sender->teleport(new Position(1, 1, 1, Server::getInstance()->getWorldManager()->getWorldByName("world")));
                $sender->sendMessage(Manager::Prefix . "Vous avez bien été téléporté au §6Totem !");
                break;
            case 3:
                $sender->teleport(new Position(1, 1, 1, Server::getInstance()->getWorldManager()->getWorldByName("world")));
                $sender->sendMessage(Manager::Prefix . "Vous avez bien été téléporté à l'§6OutPost !");
                break;

            }
        });

        $form->setTitle(Manager::Prefix . "§6Evènements");
        $form->setContent(Manager::flchMenu . 'Où voulez vous aller ?');
        $form->addButton(Manager::flchMenu . 'Nexus');
        $form->addButton(Manager::flchMenu . "KOTH");
        $form->addButton(Manager::flchMenu . "Totem");
        $form->addButton(Manager::flchMenu . "OutPost");
        $form->sendToPlayer($sender);
    }
}