<?php

namespace viskaraze\API;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use viskaraze\forms\shopForm;
use viskaraze\zCore;

class shopUI
{
    public static $category = ["Items", "Minerais", "Armures / épées", "Autres", "Loots spawner", "Cultures", "Bloc / Décoration", "SeedPlanter"];
    public static function getAllCategory() :array{
        return shopUI::$category;
    }

    public static function getItemExist($itemName) :bool
    {
        $configFile = zCore::getInstance()->getDataFolder() . 'shop.yml';
        $config = new Config($configFile, Config::YAML);
        $configAll = $config->getAll();

        foreach ($configAll as $item => $underArray) {
            $tete = $item;
            if ($itemName === $tete){
                return true;
            }
        }
        return false;
    }

    public static function getAllItems() :array
    {
        $configFile = zCore::getInstance()->getDataFolder() . 'shop.yml';
        $config = new Config($configFile, Config::YAML);
        $configAll = $config->getAll();
        return $configAll;
    }

    public static function registerNewItem(string $itemName, string $label, string $category, float $PriceBuy, float $PriceSell)
    {
        $configFile = zCore::getInstance()->getDataFolder() . 'shop.yml';
        $config = new Config($configFile, Config::YAML);

        $itemData = [
            "label" => $label,
            "stringNameItem" => $itemName,
            "prixAchat" => $PriceBuy,
            "prixVente" => $PriceSell,
            "category" => $category
        ];

        $config->set($itemName, $itemData);
        $config->save();
    }

    public static function openCategory(Player $player, int $categorie)
    {
        shopForm::OpenShopUiCategorie($player, $categorie);
    }

}