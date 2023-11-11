<?php

namespace viskaraze\items\armor\sodalite;

use customiesdevs\customies\item\component\AllowOffHandComponent;
use customiesdevs\customies\item\component\ArmorComponent;
use customiesdevs\customies\item\component\DurabilityComponent;
use customiesdevs\customies\item\component\HandEquippedComponent;
use customiesdevs\customies\item\component\ItemComponent;
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

class sodalite_jambieres extends Armor implements ItemComponents
{
    use ItemComponentsTrait;
    public function __construct(ItemIdentifier $identifier, string $name) {
        parent::__construct($identifier, $name, new ArmorTypeInfo(3, 500, ArmorInventory::SLOT_LEGS));
        $creativeInfo = new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_EQUIPMENT,CreativeInventoryInfo::GROUP_LEGGINGS);
        $this->initComponent("sodalite_jambieres", $creativeInfo);
        $this->addComponent(new WearableComponent(WearableComponent::SLOT_ARMOR_LEGS));
        $this->addComponent(new MaxStackSizeComponent(1));
        $this->addComponent(new ArmorComponent(protection: 0,textureType: "diamond"));
        $this->addComponent(new DurabilityComponent(500));
        $this->setupRenderOffsets(32, 32, false);
    }
    public function getMaxDurability(): int
    {
        return 500;
    }
    public function getDefensePoints(): int
    {
        return 3;
    }
}