<?php

namespace viskaraze\events\players;

use pocketmine\data\bedrock\EffectIdMap;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\StringToItemParser;
use viskaraze\Manager;
use viskaraze\Utils\ConfigManager;

class onUse implements Listener
{
    public $time = [];

    public function onUse(PlayerItemUseEvent $event)
    {
        $player = $event->getPlayer();
        $itemname = StringToItemParser::getInstance()->lookupAliases($player->getInventory()->getItemInHand());
       if ($itemname[0] === "slime_ball") {
            if ($player->getHealth() == $player->getMaxHealth()) {
                $event->cancel();
            } else {
                $item = $event->getItem();
                $player->setHealth($player->getHealth() + 6);
                $itemreplace = $item;
                $itemreplace->setCount($item->getCount() - 1);
                $player->getInventory()->setItemInHand($itemreplace);
                $player->sendPopup("§c+3");
            }
        }

        ###############################################################
        ###############################################################
        ###############################################################
        ###############################################################

        $item = $event->getItem();
        $all = ConfigManager::getConfigStick()->getAll();
        $in = array_keys($all);
        $itemname = StringToItemParser::getInstance()->lookupAliases($item);
        $itemname = $itemname[0];

        if(in_array("$itemname", $in)){
            $stick = $all["$itemname"];
            $effect = $stick["effect"];
            $bool = $stick["remove"];
            if(array_key_exists('permission', $stick)){
                if($stick['permission']['enable']){
                    if(!$player->hasPermission($stick['permission']['perm'])){
                        $player->sendMessage(str_replace('{player}', $player->getName(), $stick['permission']['message_perm']));
                        return;
                    }
                }
            }

            if(!isset($this->time[$player->getName()])){
                $this->time[$player->getName()] = time() + (int)$stick["cooldown"];
                foreach($effect as $id => $values) {
                    $player->getEffects()->add(new EffectInstance(EffectIdMap::getInstance()->fromId($id), (int)$values["duration"] * 20, (int)$values["niveau"] + 1, $values["visible"]));
                    if($bool === true){
                        $player->getInventory()->removeItem($player->getInventory()->getItemInHand()->pop());
                    }
                }
            } elseif(time() < $this->time[$player->getName()]) {
                $time = $this->time[$player->getName()] - time();
                if(isset($stick["message"])){
                    $player->sendMessage(Manager::ErrorPrefix . "Vous devez attendre encore " . $time . " secondes à attendre !");
                }
            } else {
                unset($this->time[$player->getName()]);
            }
        }

        ###############################################################
        ###############################################################
        ###############################################################
        ###############################################################
        if ($itemname === "soupe"){
            if ($player->getHealth() >= $player->getMaxHealth())
            {
                $player->sendPopup(Manager::ErrorPrefix . "Tu n'as pas besoin d'être soigné");
            } else {
                $count = $event->getItem()->getCount();
                $item->setCount($count - 1);
                $player->getInventory()->setItemInHand($item);
                $player->setHealth($player->getHealth() + 6);
                $player->sendPopup("§a+3");
            }
        }
    }
}