<?php

namespace viskaraze\items\sword;

use customiesdevs\customies\item\component\AllowOffHandComponent;
use customiesdevs\customies\item\component\DurabilityComponent;
use customiesdevs\customies\item\component\HandEquippedComponent;
use customiesdevs\customies\item\component\MaxStackSizeComponent;
use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\ItemComponents;
use customiesdevs\customies\item\ItemComponentsTrait;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\Sword;
use pocketmine\item\ToolTier;

class EpeeCitrine extends Sword implements ItemComponents
{
    use ItemComponentsTrait;
    public function __construct($identifier, string $name) {

        parent::__construct($identifier, $name, ToolTier::DIAMOND());
        $creativeInfo = new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_EQUIPMENT, CreativeInventoryInfo::GROUP_SWORD);
        $this->initComponent("epee_citrine", $creativeInfo);
        $this->addComponent(new HandEquippedComponent(true));
        $this->addComponent(new AllowOffHandComponent(false));
        $this->addComponent(new DurabilityComponent(1000));
        $this->addComponent(new MaxStackSizeComponent(1));
    }

    public function getMaxDurability(): int {
        return 3122;
    }
    public function getAttackPoints(): int
    {
        return 9;
    }
}