<?php

namespace viskaraze\crops\manager;

use customiesdevs\customies\block\CustomiesBlockFactory;
use pocketmine\block\{Block,
    BlockBreakInfo,
    BlockTypeInfo,
    BlockIdentifier,
    VanillaBlocks,
    Flowable
};
use pocketmine\item\Fertilizer;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class Crops2 extends Flowable
{
    public string $ids;

    public function __construct($idInfo, string $name, BlockTypeInfo $typeInfo, string $ids)
    {
        $this->ids = $ids;
        parent::__construct($idInfo, $name, $typeInfo);
    }

    public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null): bool
    {
        if ($blockReplace->getSide(Facing::DOWN)->getTypeId() === CustomiesBlockFactory::getInstance()->get("customies:terre_fertile")->getTypeId()) {
            return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
        }
        return false;
    }

    public function onNearbyBlockChange(): void
    {
        if ($this->getSide(Facing::DOWN)->getTypeId() !== CustomiesBlockFactory::getInstance()->get("customies:terre_fertile")->getTypeId()) {
            $this->position->getWorld()->useBreakOn($this->position);
        }
    }

    public function ticksRandomly(): bool
    {
        return true;
    }

    public function onRandomTick(): void
    {
        $skyra = mt_rand(0, 32);
        if ($skyra <= 2) {
            $blocks = match ($this->getTypeId()) {
                CustomiesBlockFactory::getInstance()->get($this->ids . "_0")->getTypeId() => CustomiesBlockFactory::getInstance()->get($this->ids . "_1"),
                CustomiesBlockFactory::getInstance()->get($this->ids . "_1")->getTypeId() => CustomiesBlockFactory::getInstance()->get($this->ids . "_2"),
                default => CustomiesBlockFactory::getInstance()->get($this->ids . "_2")
            };
            $this->getPosition()->getWorld()->setBlock($this->getPosition(), $blocks);
        }
    }

    public function getHardness(): float
    {
        return -1;
    }

}
