<?php
namespace viskaraze\items\farming;

use customiesdevs\customies\block\CustomiesBlockFactory;
use customiesdevs\customies\item\component\{AllowOffHandComponent,
    MaxStackSizeComponent,
    HandEquippedComponent
};
use customiesdevs\customies\item\{CreativeInventoryInfo,
    ItemComponents,
    ItemComponentsTrait
};
use pocketmine\item\Item;
use pocketmine\block\Block;
use viskaraze\Utils\CropsIdentifier;

class GrainesZelurite extends Item implements ItemComponents {
    use ItemComponentsTrait;

    public function __construct($identifier, string $name) {

        parent::__construct($identifier, $name);
        $creativeInfo = new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_ITEMS, CreativeInventoryInfo::NONE);
        $this->initComponent("graines_zelurite", $creativeInfo);
        $this->addComponent(new HandEquippedComponent(false));
        $this->addComponent(new AllowOffHandComponent(false));
        $this->addComponent(new MaxStackSizeComponent(64));
        $this->setupRenderOffsets(32,32,false);
        
    }
    
     public function getBlock(?int $clickedFace = null) : Block{
        
        return CustomiesBlockFactory::getInstance()->get(CropsIdentifier::ZELU_CROP. "_0");
    }
}