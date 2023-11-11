<?php
namespace viskaraze\blocks;

use pocketmine\block\{Opaque,
    BlockTypeInfo,
};


class TerreFertile extends Opaque {

   public function __construct($identifier, string $name, BlockTypeInfo $typeInfo) {
       parent::__construct($identifier, $name, $typeInfo, "terre_fertile");
   }
    
    public function getFrictionFactor(): float{
		return 0.4;
	}
}