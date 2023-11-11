<?php

namespace viskaraze\items\stick;

use customiesdevs\customies\item\component\AllowOffHandComponent;
use customiesdevs\customies\item\component\HandEquippedComponent;
use customiesdevs\customies\item\component\MaxStackSizeComponent;
use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\ItemComponents;
use customiesdevs\customies\item\ItemComponentsTrait;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;

class speed extends Item implements ItemComponents
{
    use ItemComponentsTrait;
    public function __construct(ItemIdentifier $identifier, string $name) {
        parent::__construct($identifier, $name);
        $creativeInfo = new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_ITEMS, CreativeInventoryInfo::NONE);
        $this->initComponent("stickspeed", $creativeInfo);
        $this->addComponent(new HandEquippedComponent(true));
        $this->addComponent(new AllowOffHandComponent(false));
        $this->addComponent(new MaxStackSizeComponent(1));
    }
}