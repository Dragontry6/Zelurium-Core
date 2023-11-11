<?php

namespace viskaraze\commands\player\all;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Location;
use pocketmine\lang\Translatable;
use pocketmine\Server;
use pocketmine\world\Position;
use viskaraze\Entity\NexusEntity;
use viskaraze\zCore;
use viskaraze\Manager;

class nexus extends Command
{
    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("everyone");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $worldConfig = "spawn1";
        $world = zCore::getInstance()->getServer()->getWorldManager()->getWorldByName($worldConfig);
        $sender->teleport(new Position(-197, 80, 93, $world));
        $sender->sendMessage(Manager::Prefix . "Vous avez été téléporter au nexus !");
        if (isset($args[0])){
            switch ($args[0]) {
                case "start":
                    if ($sender->hasPermission("nexus.start")) {
                        $coord = explode(":", zCore::getInstance()->getConfig()->getNested("Nexus-Settings.AutoSpawn.position"));
                        Server::getInstance()->getWorldManager()->loadWorld($coord[3]);
                        foreach (Server::getInstance()->getWorldManager()->getWorlds() as $world) {
                            foreach ($world->getEntities() as $entity) {
                                if ($entity instanceof NexusEntity) {
                                    $entity->kill();
                                }
                            }
                        }
                        $entity = new NexusEntity(new Location((int)$coord[0], (int)$coord[1], (int)$coord[2], Server::getInstance()->getWorldManager()->getWorldByName($coord[3]), 0, 0));
                        $entity->spawnToAll();
                        Server::getInstance()->broadcastMessage(Manager::Prefix . "Un §6Nexus vient de spawn !");
                    }
                    break;
            }
        }
    }

}