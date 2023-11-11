<?php

namespace viskaraze;

use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\entity\EntityFactory;
use pocketmine\entity\Location;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use pocketmine\world\World;
use viskaraze\API\NexusAPI;
use viskaraze\API\VoteParty;
use viskaraze\Entity\TopDeaths;
use viskaraze\Entity\TopFaction;
use viskaraze\Entity\TopKills;
use viskaraze\Entity\TopMoney;
use viskaraze\protection\Protection;
use viskaraze\Utils\ConfigManager;
use viskaraze\Utils\Register;

class zCore extends PluginBase
{
    use SingletonTrait;

    private static Config $time;
    public static Config $joinJSON;
    public static Config $Kills;
    public static Config $Deaths;

    private static Register $register;
    public static Config $configKit;
    public static Config $voteparty;
    public static VoteParty $voteParty;

    protected function onEnable(): void
    {
        self::setInstance($this);
        self::$voteParty = new VoteParty();
        $this->saveDefaultConfig();
        ConfigManager::registerConfigEnderChestSlot();

        new BlockLoader();
        new CropsLoader();

        $this->saveResource("shop.yml");
        $this->saveResource("config.yml");
        $this->saveResource("kits.yml");
        $this->saveResource("stick.yml");

        Register::initAllEvents();
        Register::initAllCommands();
        Register::initAllTasks();
        NexusAPI::registerNexus();
        Register::initAllItem();
        Protection::startProtection();
        Register::initAllBlock();

        self::$register = new Register();
        self::$time = new Config($this->getDataFolder() . "Time.json", Config::JSON);
        self::$joinJSON = new Config($this->getDataFolder() . "playerJoin.json", Config::JSON);
        self::$Kills = new Config($this->getDataFolder() . "kills.json", Config::JSON);
        self::$Deaths = new Config($this->getDataFolder() . "deaths.json", Config::JSON);
        self::$configKit = new Config($this->getDataFolder() . "kits.yml", Config::YAML);
        self::$voteparty = new Config($this->getDataFolder() . "voteparty.json", Config::JSON);

        self::getInstance()->getServer()->getNetwork()->setName("§l§6» §r§6KitMap Zélurium");

        self::getInstance()->getServer()->getWorldManager()->loadWorld("spawn");
        self::$register->initAllLeaderboard();

        EntityFactory::getInstance()->register(TopDeaths::class, function (World $world, CompoundTag $nbt): TopDeaths {
            return new TopDeaths(new Location(-16, 89, -16, zCore::getInstance()->getServer()->getWorldManager()->getWorldByName("spawn1"), 0.0, 0.0), zCore::getInstance()->getServer()->getWorldManager()->getWorldByName("spawn1"), "");
        }, ["TopDeaths"]);
        EntityFactory::getInstance()->register(TopKills::class, function (World $world, CompoundTag $nbt): TopKills {
            return new TopKills(new Location(-32, 89, 0, zCore::getInstance()->getServer()->getWorldManager()->getWorldByName("spawn1"), 0.0, 0.0), zCore::getInstance()->getServer()->getWorldManager()->getWorldByName("spawn1"), "");
        }, ["TopKills"]);
        EntityFactory::getInstance()->register(TopMoney::class, function (World $world, CompoundTag $nbt): TopMoney {
            return new TopMoney(new Location(-16, 89, 0, zCore::getInstance()->getServer()->getWorldManager()->getWorldByName("spawn1"), 0.0, 0.0), zCore::getInstance()->getServer()->getWorldManager()->getWorldByName("spawn1"), "");
        }, ["TopMoney"]);
        EntityFactory::getInstance()->register(TopFaction::class, function (World $world, CompoundTag $nbt): TopFaction {
            return new TopFaction(new Location(-32, 89, -16, zCore::getInstance()->getServer()->getWorldManager()->getWorldByName("spawn1"), 0.0, 0.0), zCore::getInstance()->getServer()->getWorldManager()->getWorldByName("spawn1"), "");
        }, ["TopFaction"]);
    }

    public function getTime(Player $player, string $kit): int
    {
        if (self::$time->getNested($player->getName() . ".$kit") !== null) {
            return self::$time->get($player->getName())[$kit];
        } else return 0;
    }

    public function setTime(Player $player, string $kit, int $time): void
    {
        self::$time->setNested($player->getName() . ".$kit", time() + $time);
        self::$time->save();
    }

    public function getItem(array $array): ?Item
    {
        if ((is_numeric($array[1]))) {
            var_dump($array[0]);
            $item = StringToItemParser::getInstance()->parse($array[0]);
            $item->setCount($array[1]);
            if ((isset($array[2])) and (is_array($array[2]))) {
                foreach ($array[2] as $enchant) {
                    var_dump($enchant);
                    if ((is_numeric($enchant[0])) and (is_numeric($enchant[1]))) {
                        $item->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId($enchant[0]), $enchant[1]));
                    }
                }
                return $item;
            } else return $item;
        } else return null;
    }

    public function getConfigManager()
    {

    }
}