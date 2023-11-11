<?php

namespace viskaraze\items\armor\fluorine;

use customiesdevs\customies\item\component\ArmorComponent;
use customiesdevs\customies\item\component\DurabilityComponent;
use customiesdevs\customies\item\component\MaxStackSizeComponent;
use customiesdevs\customies\item\component\WearableComponent;
use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\ItemComponents;
use customiesdevs\customies\item\ItemComponentsTrait;
use pocketmine\inventory\ArmorInventory;
use pocketmine\item\Armor;
use pocketmine\item\ArmorTypeInfo;
use pocketmine\item\ItemIdentifier;
use pocketmine\nbt\tag\CompoundTag;

class fluorine_bottes extends Armor implements ItemComponents
{
    use ItemComponentsTrait;
    public function __construct(ItemIdentifier $identifier, string $name) {
        parent::__construct($identifier, $name, new ArmorTypeInfo(4, 850, ArmorInventory::SLOT_FEET));
        $creativeInfo = new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_EQUIPMENT,CreativeInventoryInfo::GROUP_BOOTS);
        $this->initComponent("fluorine_bottes", $creativeInfo);
        $this->addComponent(new WearableComponent(WearableComponent::SLOT_ARMOR_FEET));
        $this->addComponent(new MaxStackSizeComponent(1));
        $this->addComponent(new ArmorComponent(protection: 0,textureType: "diamond"));
        $this->addComponent(new DurabilityComponent(850));
        $this->setupRenderOffsets(32, 32, false);
    }
    public function getDefensePoints(): int
    {
        return 4;
    }
    public function getMaxDurability(): int
    {
        return 850;
    }
}