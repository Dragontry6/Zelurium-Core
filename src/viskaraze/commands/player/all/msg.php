<?php

namespace viskaraze\commands\player\all;

use kingofturkey38\voting38\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\world\Position;
use viskaraze\zCore;
use viskaraze\Manager;
use viskaraze\forms\anvilForm;

class msg extends Command
{
    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("everyone");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(count($args) < 2){
            throw new InvalidCommandSyntaxException();
        }

        $toPlayer = $sender->getServer()->getPlayerByPrefix(array_shift($args));

        if ($toPlayer === $sender){
            $sender->sendMessage(Manager::ErrorPrefix . "Tu ne peux pas envoyer un message à toi même !");
            return true;
        }

        if ($toPlayer instanceof Player){
            $message = implode(" ", $args);
            $sender->sendMessage(Manager::Prefix . "Vous avez bien envoyé votre message.");
            $toPlayer->sendMessage(Manager::flchPrefix . "Vous avez reçu un message de §7" . $sender->getName() . "§r\n§7« §6" . $message . " §7»");
        } else {
            $sender->sendMessage(Manager::ErrorPrefix . "Le joueur spécifié est introuvable!");
        }

    }

}