<?php
namespace viskaraze\blocks;

use customiesdevs\customies\item\CustomiesItemFactory;
use pocketmine\block\{Opaque,
    BlockTypeInfo,
};
use pocketmine\item\Item;

class MineraisSodalite extends Opaque {

   public function __construct($identifier, string $name, BlockTypeInfo $typeInfo) {
       parent::__construct($identifier, $name, $typeInfo, "minerais_sodalite");
   }
    
    public function getFrictionFactor(): float{
		return 0.4;
	}

    public function getDropsForCompatibleTool(Item $item) : array {
        return [
            CustomiesItemFactory::getInstance()->get("customies:lingot_sodalite")
        ];
    }

    public function isAffectedBySilkTouch() : bool{
        return true;
    }


    protected function getXpDropAmount() : int{
        return mt_rand(3, 7);
    }
}