<?php

namespace viskaraze\Utils;

use pocketmine\utils\Config;
use viskaraze\zCore;

class ConfigManager
{

    public static function registerConfigEnderChestSlot() {
        if (!file_exists(zCore::getInstance()->getDataFolder() . "enderslot.yml")) {
          new Config(zCore::getInstance()->getDataFolder() . "enderslot.yml", Config::YAML, [
                "# PERMISSION: SLOT",
                "slot_default" => "2",
                "slots" => [
                    "vip.slot" => 10,
                    "player.slot" => 4
                ]
            ]);
        }
    }

    public static function getConfigEnderChestSlot() :Config{
        $config = new Config(zCore::getInstance()->getDataFolder() . "enderslot.yml", Config::YAML);
        return $config;
    }

    public static function getConfigStick()
    {
        $configFile = zCore::getInstance()->getDataFolder() . 'stick.yml';
        $config = new Config($configFile, Config::YAML);
        $config->save();
        return $config;
    }

    public static function getConfigKits() : Config{
        return zCore::$configKit;
    }

    public static function getPlayerJoinJson() : Config{
        return zCore::$joinJSON;
    }

    public static function getPlayerKills() : Config{
        return zCore::$Kills;
    }

    public static function getPlayerDeaths() : Config{
        return zCore::$Deaths;
    }
    public static function getVoteParty() : Config{
        return zCore::$voteparty;
    }
}