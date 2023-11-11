<?php

namespace viskaraze\Utils;

use customiesdevs\customies\item\CustomiesItemFactory;
use pocketmine\entity\Location;
use viskaraze\API\LeaderboardAPI;
use viskaraze\blocks\SodaliteOre;
use viskaraze\commands\admin\id;
use viskaraze\commands\player\all\anvil;
use viskaraze\commands\player\all\clearinv;
use viskaraze\commands\player\all\events;
use viskaraze\commands\player\all\kits;
use viskaraze\commands\player\all\lobby;
use viskaraze\commands\player\all\minage;
use viskaraze\commands\player\all\nexus;
use viskaraze\commands\player\all\nightvision;
use viskaraze\commands\player\all\repair;
use viskaraze\commands\player\all\repairall;
use viskaraze\commands\player\all\shop;
use viskaraze\commands\player\all\spawn;
use viskaraze\commands\player\all\msg;
use viskaraze\Entity\TopDeaths;
use viskaraze\Entity\TopFaction;
use viskaraze\Entity\TopKills;
use viskaraze\Entity\TopMoney;
use viskaraze\events\blocks\onBreak;
use viskaraze\events\blocks\onPlace;
use viskaraze\events\players\Command;
use viskaraze\events\players\InventoryTransaction;
use viskaraze\events\players\onDamage;
use viskaraze\events\players\onDeath;
use viskaraze\events\players\onUse;
use viskaraze\events\players\onJoin;
use viskaraze\events\players\onQuit;
use viskaraze\events\players\PlayerCreation;
use viskaraze\items\armor\citrine\citrine_bottes;
use viskaraze\items\armor\citrine\citrine_casque;
use viskaraze\items\armor\citrine\citrine_jambieres;
use viskaraze\items\armor\citrine\citrine_plastron;
use viskaraze\items\armor\fluorine\fluorine_bottes;
use viskaraze\items\armor\fluorine\fluorine_casque;
use viskaraze\items\armor\fluorine\fluorine_jambieres;
use viskaraze\items\armor\fluorine\fluorine_plastron;
use viskaraze\items\armor\sodalite\sodalite_bottes;
use viskaraze\items\armor\sodalite\sodalite_casque;
use viskaraze\items\armor\sodalite\sodalite_jambieres;
use viskaraze\items\armor\sodalite\sodalite_plastron;
use viskaraze\items\armor\zelurite\zelurite_bottes;
use viskaraze\items\armor\zelurite\zelurite_casque;
use viskaraze\items\armor\zelurite\zelurite_jambieres;
use viskaraze\items\armor\zelurite\zelurite_plastron;
use viskaraze\items\farming\fragment_zelurite;
use viskaraze\items\farming\GrainesZelurite;
use viskaraze\items\farming\joyau_ble;
use viskaraze\items\farming\joyau_ble_renforce;
use viskaraze\items\farming\joyau_carotte;
use viskaraze\items\farming\joyau_carotte_renforce;
use viskaraze\items\farming\joyau_pasteque;
use viskaraze\items\farming\joyau_pasteque_renforce;
use viskaraze\items\farming\joyau_patate;
use viskaraze\items\farming\joyau_patate_renforce;
use viskaraze\items\farming\noyau_zelurite;
use viskaraze\items\others\billet;
use viskaraze\items\others\lingot_fluorine;
use viskaraze\items\others\lingot_sodalite;
use viskaraze\items\others\piece;
use viskaraze\items\others\soupe;
use viskaraze\items\stick\antipearl;
use viskaraze\items\stick\force;
use viskaraze\items\stick\rocket;
use viskaraze\items\stick\speed;
use viskaraze\items\stick\tp;
use viskaraze\items\sword\EpeeCitrine;
use viskaraze\items\sword\EpeeFluorine;
use viskaraze\items\sword\EpeeZelurite;
use viskaraze\Manager;
use viskaraze\tasks\BroadCastMessage;
use viskaraze\tasks\ClearLag;
use viskaraze\tasks\Leaderboard;
use viskaraze\tasks\maxItem;
use viskaraze\tasks\nameTag;
use viskaraze\tasks\NexusSpawnTask;
use viskaraze\tasks\Scoreboard;
use viskaraze\tasks\VotePartyTask;
use viskaraze\zCore;
use viskaraze\commands\admin\addshop;


class Register
{
    public TopDeaths $topDeaths;
    public TopKills $topKills;
    public TopMoney $topMoney;
    public TopFaction $topFac;
    public static function initAllEvents()
    {
        zCore::getInstance()->getServer()->getPluginManager()->registerEvents(new onJoin(), zCore::getInstance());
        zCore::getInstance()->getServer()->getPluginManager()->registerEvents(new onQuit(), zCore::getInstance());
        zCore::getInstance()->getServer()->getPluginManager()->registerEvents(new onBreak(), zCore::getInstance());
        zCore::getInstance()->getServer()->getPluginManager()->registerEvents(new onPlace(), zCore::getInstance());
        zCore::getInstance()->getServer()->getPluginManager()->registerEvents(new onDeath(), zCore::getInstance());
        zCore::getInstance()->getServer()->getPluginManager()->registerEvents(new onUse(), zCore::getInstance());
        zCore::getInstance()->getServer()->getPluginManager()->registerEvents(new Command(), zCore::getInstance());
        zCore::getInstance()->getServer()->getPluginManager()->registerEvents(new onDamage(), zCore::getInstance());
        zCore::getInstance()->getServer()->getPluginManager()->registerEvents(new PlayerCreation(), zCore::getInstance());
        zCore::getInstance()->getServer()->getPluginManager()->registerEvents(new InventoryTransaction(), zCore::getInstance());
    }

    public static function initAllBlock(): void
    {

    }

    public function initAllLeaderboard()
    {
        /*
         * Top Deaths
         */
        $config = ConfigManager::getPlayerDeaths();
        $topDeaths = onDeath::getTopDeaths($config);

        $this->topDeaths = new TopDeaths(new Location(-16, 89, -16, zCore::getInstance()->getServer()->getWorldManager()->getWorldByName("spawn1"), 0.0, 0.0), zCore::getInstance()->getServer()->getWorldManager()->getWorldByName("spawn1"), implode("\n", $topDeaths));
        $this->topDeaths->spawnToAll();

        /*
        * Top Kills
           */
        $config = ConfigManager::getPlayerKills();
        $topKills = onDeath::getTopKills($config);

        $this->topKills = new TopKills(new Location(-32, 89, 0, zCore::getInstance()->getServer()->getWorldManager()->getWorldByName("spawn1"), 0.0, 0.0), zCore::getInstance()->getServer()->getWorldManager()->getWorldByName("spawn1"), implode("\n", $topKills));
        $this->topKills->spawnToAll();


        /*
         * Top Money
         */
        $topMoney = LeaderboardAPI::getTopMoney();

        $this->topMoney = new TopMoney(new Location(-16, 89, 0, zCore::getInstance()->getServer()->getWorldManager()->getWorldByName("spawn1"), 0.0, 0.0), zCore::getInstance()->getServer()->getWorldManager()->getWorldByName("spawn1"), $topMoney);
        $this->topMoney->spawnToAll();

        /*
         * Top Faction
         */
        $topMoney = LeaderboardAPI::getFactionTop();

        $this->topFac = new TopFaction(new Location(-32, 89, -16, zCore::getInstance()->getServer()->getWorldManager()->getWorldByName("spawn1"), 0.0, 0.0), zCore::getInstance()->getServer()->getWorldManager()->getWorldByName("spawn1"), $topMoney);
        $this->topFac->spawnToAll();

        zCore::getInstance()->getScheduler()->scheduleRepeatingTask(new Leaderboard($this->topDeaths, $this->topKills, $this->topMoney, $this->topFac), 20);
    }

    public static function initAllCommands() {
        $commands = ["kill", "about", "pl", "tell", "me", "help", "clear", "checkperm"];
        foreach ($commands as $command) {
            zCore::getInstance()->getServer()->getCommandMap()->unregister(zCore::getInstance()->getServer()->getCommandMap()->getCommand($command));
        }

        zCore::getInstance()->getServer()->getCommandMap()->registerAll("Zélurium", [
            new spawn("spawn", Manager::Prefix . "Permet d'aller au spawn", "/spawn"),
            new addshop("addshop", Manager::Prefix . "Test de viska", "/test"),
            new shop("shop", Manager::Prefix . "Permet d'accèder au shop !", "/shop"),
            new events("events", Manager::Prefix . "Permet d'accèder au menu event", "/event"),
            new nightvision("nightvision", Manager::Prefix . "Permet d'activer le NightVision", "/nv", ["nv", 'vision']),
            new anvil("anvil", Manager::Prefix . "Permet d'ouvrir l'enclume", "/anvil", ["enclume", 'vision']),
            new kits("kits", Manager::Prefix . "Permet d'ouvrir l'interface des kits", "/kits", ["kit", 'kt']),
            new lobby("lobby", Manager::Prefix . "Permet d'aller sur le lobby", "/lobby", []),
            new msg("msg", Manager::Prefix . "Permet d'envoyer un message à un joueur", "/msg [joueur] [message]", ["privatemessage"]),
            new clearinv("clear", Manager::Prefix . "Permet de vider votre inventaire et supprimer votre armure", "/clear", ["clearinv", "clearme"]),
            new minage("minage", Manager::Prefix . "Permet de vous téléporter au minage !", "/minage", ["minetp"]),
            new repair("repair", Manager::Prefix . "Permet de réparer l'objet dans votre main !", "/repair", ["rpr"]),
            new repairall("repairall", Manager::Prefix . "Permet de réparer tous les items de votre inventaire !", "/repairall", ["rprall"]),
            new id("id", Manager::Prefix . "Permet de voir l'id", "/id", []),
            new nexus("nexus", Manager::Prefix . "Permet de vous téléporter au nexus !", "/nexus", ["nexustp"]),
        ]);
    }

    public static function initAllTasks()
    {
        zCore::getInstance()->getScheduler()->scheduleRepeatingTask(new ClearLag(), 20);
        zCore::getInstance()->getScheduler()->scheduleRepeatingTask(new nameTag(), 20);
        zCore::getInstance()->getScheduler()->scheduleDelayedRepeatingTask(new NexusSpawnTask(), 5400*20, 5400*20);
        zCore::getInstance()->getScheduler()->scheduleRepeatingTask(new maxItem(), 10);
        zCore::getInstance()->getScheduler()->scheduleRepeatingTask(new BroadCastMessage(), 20);
       zCore::getInstance()->getScheduler()->scheduleRepeatingTask(new Scoreboard(), 20);

    }

    public static function initAllItem(): void
    {
        ## Other ##
        CustomiesItemFactory::getInstance()->registerItem(billet::class, "customies:billet", "Billet");
        CustomiesItemFactory::getInstance()->registerItem(piece::class, "customies:piece_or", "§ePièce");
        CustomiesItemFactory::getInstance()->registerItem(soupe::class, "customies:soupe", "§cSoupe");
        CustomiesItemFactory::getInstance()->registerItem(lingot_sodalite::class, "customies:lingot_sodalite", "Sodalite");
        CustomiesItemFactory::getInstance()->registerItem(lingot_fluorine::class, "customies:lingot_fluorine", "Fluorine");

        /*
         * Farming
         */
        CustomiesItemFactory::getInstance()->registerItem(joyau_carotte::class, "customies:joyau_carotte", "Joyau de carotte");
        CustomiesItemFactory::getInstance()->registerItem(joyau_carotte_renforce::class, "customies:joyau1_carotte", "Joyau de carotte renforcé");

        CustomiesItemFactory::getInstance()->registerItem(joyau_pasteque::class, "customies:joyau_pasteque", "Joyau de pastèque");
        CustomiesItemFactory::getInstance()->registerItem(joyau_pasteque_renforce::class, "customies:joyau1_pasteque", "Joyau de pastèque renforcé");

        CustomiesItemFactory::getInstance()->registerItem(joyau_patate::class, "customies:joyau_patate", "Joyau de patate");
        CustomiesItemFactory::getInstance()->registerItem(joyau_patate_renforce::class, "customies:joyau1_patate", "Joyau de patate renforcé");

        CustomiesItemFactory::getInstance()->registerItem(joyau_ble::class, "customies:joyau_ble", "Joyau de blé");
        CustomiesItemFactory::getInstance()->registerItem(joyau_ble_renforce::class, "customies:joyau1_ble", "Joyau de blé renforcé");

        CustomiesItemFactory::getInstance()->registerItem(fragment_zelurite::class, "customies:fragment_zelurite", "Fragment de Zélurite");
        CustomiesItemFactory::getInstance()->registerItem(noyau_zelurite::class, "customies:noyau_zelurite", "Noyau en Zélurite");
        CustomiesItemFactory::getInstance()->registerItem(GrainesZelurite::class, "customies:graines_zelurite", "Graine de Zélurite");

        /*
         * Stick
         */
        CustomiesItemFactory::getInstance()->registerItem(antipearl::class, "customies:antipearl", "§aStick AntiPearl");
        CustomiesItemFactory::getInstance()->registerItem(tp::class, "customies:sticktp", "§cStick de TP");
        CustomiesItemFactory::getInstance()->registerItem(speed::class, "customies:stickspeed", "§aStick de speed");
        CustomiesItemFactory::getInstance()->registerItem(force::class, "customies:stickforce", "§cStick de force");
        CustomiesItemFactory::getInstance()->registerItem(rocket::class, "customies:rocket", "§aRocket");


        /*
         * Epées
         */
        CustomiesItemFactory::getInstance()->registerItem(EpeeCitrine::class, "customies:epee_citrine", "§eEpée en Citrine");
        CustomiesItemFactory::getInstance()->registerItem(EpeeZelurite::class, "customies:epee_zelurite", "§aEpée en Zélurite");
        CustomiesItemFactory::getInstance()->registerItem(EpeeFluorine::class, "customies:epee_fluorine", "§dEpée en Fluorine");
        /*
         * Armor
         */
        /**
         * Sodalite
         */
        CustomiesItemFactory::getInstance()->registerItem(sodalite_casque::class, "customies:sodalite_casque", "§9Casque en sodalite");
        CustomiesItemFactory::getInstance()->registerItem(sodalite_plastron::class, "customies:sodalite_plastron", "§9Plastron en sodalite");
        CustomiesItemFactory::getInstance()->registerItem(sodalite_jambieres::class, "customies:sodalite_jambieres", "§9Jambières en sodalite");
        CustomiesItemFactory::getInstance()->registerItem(sodalite_bottes::class, "customies:sodalite_bottes", "§9Bottes en sodalite");
        /**
         * Zélurite
         */
        CustomiesItemFactory::getInstance()->registerItem(zelurite_casque::class, "customies:zelurite_casque", "§aCasque en Zélurite");
        CustomiesItemFactory::getInstance()->registerItem(zelurite_plastron::class, "customies:zelurite_plastron", "§aPlastron en Zélurite");
        CustomiesItemFactory::getInstance()->registerItem(zelurite_jambieres::class, "customies:zelurite_jambieres", "§aJambières en Zélurite");
        CustomiesItemFactory::getInstance()->registerItem(zelurite_bottes::class, "customies:zelurite_bottes", "§aBottes en Zélurite");
        /**
         * Citrine
         */
        CustomiesItemFactory::getInstance()->registerItem(citrine_casque::class, "customies:citrine_casque", "§eCasque en Citrine");
        CustomiesItemFactory::getInstance()->registerItem(citrine_plastron::class, "customies:citrine_plastron", "§ePlastron en Citrine");
        CustomiesItemFactory::getInstance()->registerItem(citrine_jambieres::class, "customies:citrine_jambieres", "§eJambières en Citrine");
        CustomiesItemFactory::getInstance()->registerItem(citrine_bottes::class, "customies:citrine_bottes", "§eBottes en Citrine");
        /**
         * Fluorine
         */
        CustomiesItemFactory::getInstance()->registerItem(fluorine_casque::class, "customies:fluorine_casque", "§dCasque en Fluorine");
        CustomiesItemFactory::getInstance()->registerItem(fluorine_plastron::class, "customies:fluorine_plastron", "§dPlastron en Fluorine");
        CustomiesItemFactory::getInstance()->registerItem(fluorine_jambieres::class, "customies:fluorine_jambieres", "§dJambières en Fluorine");
        CustomiesItemFactory::getInstance()->registerItem(fluorine_bottes::class, "customies:fluorine_bottes", "§dBottes en Fluorine");
    }
}