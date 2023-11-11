<?php

namespace viskaraze\tasks;

use pocketmine\block\Air;
use pocketmine\item\ItemFactory;
use pocketmine\item\StringToItemParser;
use pocketmine\item\VanillaItems;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use viskaraze\zCore;

class maxItem extends Task
{

    public function onRun(): void
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $player){
            foreach (zCore::getInstance()->getConfig()->get("maxItem",[]) as $itemData){

                $count = 0;
                $index= [];
                foreach ($player->getInventory()->getContents(true) as $slot => $item){
                    $itemname = StringToItemParser::getInstance()->lookupAliases($item);
                    if($itemname[0] === $itemData["name"]){
                        $count+= $item->getCount();
                        $index[] = $slot;
                    }
                }
                if($count > $itemData["max"]){
                    foreach ($index as $i){
                        $player->getInventory()->setItem($i, VanillaItems::AIR());
                    }
                    $itemtoreplace = StringToItemParser::getInstance()->parse($itemData["name"]);
                    $itemtoreplace->setCount($itemData["max"]);
                    $player->getInventory()->addItem($itemtoreplace);
                }


            }
        }
    }
}