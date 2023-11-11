<?php

namespace viskaraze\forms;

use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\data\bedrock\EffectIdMap;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;
use pocketmine\player\Player;
use pocketmine\Server;
use viskaraze\zCore;
use viskaraze\Utils\ConfigManager;

class KitForms
{
    public static function listCategory(Player $player): SimpleForm
    {
        $config = ConfigManager::getConfigKits();
        $form = new SimpleForm(function (Player $player, $data = null) {
            if (($data === null) or ($data === "back")) return;

            self::listKit($player, $data);
        });
        $form->setTitle($config->get("title"));
        if ($config->get("content") !== null) {
            $form->setContent($config->get("content"));
        }
        foreach ($config->get("category") as $name) {
            $form->addButton($name, -1, "", $name);
        }
        if ($config->get("back_button") !== null) {
            $form->addButton($config->get("back_button"), -1, "", "back");
        }
        $form->sendToPlayer($player);
        return $form;
    }

    public static function listKit(Player $player, string $category = null): SimpleForm
    {
        $config = ConfigManager::getConfigKits();
        $form = new SimpleForm(function (Player $player, $data = null) use ($config, $category) {
            if (($data === null) or ($data === "back")) {
                if ($category !== null) {
                    self::listCategory($player);
                }
                return;
            }

            $kit = $config->get("kits")[$data];
            if ($kit["perm"] !== null) {
                if (!$player->hasPermission($kit["perm"])) {
                    $player->sendMessage($config->get("no_perm"));
                    return;
                }
            }

            if ((zCore::getInstance()->getTime($player, $data) < time()) or (zCore::getInstance()->getTime($player, $data) == 0)) {

                $eco = "EconomyAPI";
                $pl = Server::getInstance()->getPluginManager()->getPlugin($eco);
               if ($eco === "EconomyAPI") {
                    if ($kit["cost"] > 0) {
                        if ($pl->myMoney($player) < $kit["cost"]) {
                            $player->sendMessage($config->get("no_money"));
                            return;
                        }
                        $pl->reduceMoney($player, $kit["cost"]);
                    }
                }

                foreach ($kit["items"] as $i) {
                    $item = zCore::getInstance()->getItem($i);

                    if ($player->getInventory()->canAddItem($item)) {
                        $player->getInventory()->addItem($item);
                    }
                    //else $player->getWorld()->dropItem($player->getPosition(), $item);
                }

                if ($kit["helmet"] !== null) {
                    $helmet = zCore::getInstance()->getItem($kit["helmet"]);
                    if ($player->getArmorInventory()->getHelmet()->isNull()) {
                        $player->getArmorInventory()->setHelmet($helmet);
                    }
                }

                if ($kit["chestplate"] !== null) {
                    $helmet = zCore::getInstance()->getItem($kit["chestplate"]);
                    if ($player->getArmorInventory()->getChestplate()->isNull()) {
                        $player->getArmorInventory()->setChestplate($helmet);
                    }
                }

                if ($kit["leggings"] !== null) {
                    $helmet = zCore::getInstance()->getItem($kit["leggings"]);
                    if ($player->getArmorInventory()->getLeggings()->isNull()) {
                        $player->getArmorInventory()->setLeggings($helmet);
                    }
                }

                if ($kit["boots"] !== null) {
                    $helmet = zCore::getInstance()->getItem($kit["boots"]);
                    if ($player->getArmorInventory()->getBoots()->isNull()) {
                        $player->getArmorInventory()->setBoots($helmet);
                    }
                }

                if ($kit["effects"] !== null) {
                    foreach ($kit["effects"] as $effect) {
                        $player->getEffects()->add(new EffectInstance(EffectIdMap::getInstance()->fromId($effect[0]), 20 * $effect[2], $effect[1], $effect[3]));
                    }
                }

                $t = $kit["time"];
                if (is_array($t)) {
                    $time = $t[0] * 24 * 60 * 60;
                    if ((isset($t[1])) and (is_numeric($t[1]))) $time += $t[1] * 60 * 60;
                    if ((isset($t[2])) and (is_numeric($t[2]))) $time += $t[2] * 60;
                    if ((isset($t[3])) and (is_numeric($t[3]))) $time += $t[3];
                    zCore::getInstance()->setTime($player, $data, $time);
                }
            } else $player->sendMessage($config->get("no_time"));
        });
        $form->setTitle($config->get("title"));
        if ($config->get("content") !== null) {
            $form->setContent($config->get("content"));
        }
        foreach ($config->get("kits") as $name => $key) {
            if ($category === null) {
                if ($key["perm"] !== null) {
                    if ($player->hasPermission($key["perm"])) {
                        $form->addButton(str_replace("{cost}", $key["cost"], $key["button"]), -1, "", $name);
                    }
                } else $form->addButton(str_replace("{cost}", $key["cost"], $key["button"]), -1, "", $name);
            } else {
                if ($key["category"] === $category) {
                    if ($key["perm"] !== null) {
                        if ($player->hasPermission($key["perm"])) {
                            $form->addButton(str_replace("{cost}", $key["cost"], $key["button"]), -1, "", $name);
                        }
                    } else $form->addButton(str_replace("{cost}", $key["cost"], $key["button"]), -1, "", $name);
                }
            }
        }
        if ($config->get("back_button") !== null) {
            $form->addButton($config->get("back_button"), -1, "", "back");
        }
        $form->sendToPlayer($player);
        return $form;
    }

    public static function addKitForm(Player $player): CustomForm
    {
        $config = ConfigManager::getConfigKits();
        $form = new CustomForm(function (Player $player, array $data = null) use ($config) {
            if ($data === null) return;

            if ($data[1] !== "") {
                if ($data[2] !== "") {
                    if (is_numeric($data[2])) {
                        if ($config->getNested("kits.$data[1]") === null) {
                            if (isset($data[8])) $category = $config->get("category")[$data[8]]; else $category = null;
                            if ($data[3] === "") $perm = null; else $perm = $data[3];
                            $time = [$data[4], $data[5], $data[6], $data[7]];

                            if ($player->getArmorInventory()->getHelmet()->isNull()) $helmet = null; else $helmet = [StringToItemParser::getInstance()->lookupAliases($player->getArmorInventory()->getHelmet())[0], 1, self::getEnchantmentsOfItem($player->getArmorInventory()->getHelmet())];
                            if ($player->getArmorInventory()->getChestplate()->isNull()) $chestplate = null; else $chestplate = [StringToItemParser::getInstance()->lookupAliases($player->getArmorInventory()->getChestplate())[0], 1, self::getEnchantmentsOfItem($player->getArmorInventory()->getChestplate())];
                            if ($player->getArmorInventory()->getLeggings()->isNull()) $leggings = null; else $leggings = [StringToItemParser::getInstance()->lookupAliases($player->getArmorInventory()->getLeggings())[0], 1, self::getEnchantmentsOfItem($player->getArmorInventory()->getLeggings())];
                            if ($player->getArmorInventory()->getBoots()->isNull()) $boots = null; else $boots = [StringToItemParser::getInstance()->lookupAliases($player->getArmorInventory()->getBoots())[0], 1, self::getEnchantmentsOfItem($player->getArmorInventory()->getBoots())];
                            $items = [];
                            foreach ($player->getInventory()->getContents() as $content) {
                                $items[] = [StringToItemParser::getInstance()->lookupAliases($content)[0], $content->getCount(), self::getEnchantmentsOfItem($content)];
                            }
                            $kit = [
                                "category" => $category,
                                "perm" => $perm,
                                "cost" => $data[2],
                                "button" => $data[1],
                                "effects" => null,
                                "items" => $items,
                                "helmet" => $helmet,
                                "chestplate" => $chestplate,
                                "leggings" => $leggings,
                                "boots" => $boots,
                                "time" => $time
                            ];
                            $config->setNested("kits.$data[1]", $kit);
                            $config->save();
                            $player->sendMessage(str_replace("{kit}", $data[1], $config->get("create")));
                        } else $player->sendMessage($config->get("exist"));
                    } else $player->sendMessage($config->get("is_numeric"));
                } else $player->sendMessage($config->get("no_price"));
            } else $player->sendMessage($config->get("no_title"));
        });
        $form->setTitle($config->get("title"));
        $form->addLabel($config->get("label")); # 0
        $form->addInput($config->get("input_name")); # 1
        $form->addInput($config->get("input_price"), "", "0"); # 2
        $form->addInput($config->get("input_perm")); # 3
        $form->addSlider($config->get("slider_day"), 0, 30); # 4
        $form->addSlider($config->get("slider_hour"), 0, 24); # 5
        $form->addSlider($config->get("slider_minute"), 0, 60); # 6
        $form->addSlider($config->get("slider_second"), 0, 60); # 7
        if (!empty($config->get("category"))) {
            $form->addDropdown($config->get("dropdown"), $config->get("category")); # 8
        }
        $form->sendToPlayer($player);
        return $form;
    }

    public static function getEnchantmentsOfItem(Item $item): array
    {
        $enchant = [];
        foreach ($item->getEnchantments() as $enchantment) {
            $enchant[] = [EnchantmentIdMap::getInstance()->toId($enchantment->getType()), $enchantment->getLevel()];
        }
        return $enchant;
    }
}