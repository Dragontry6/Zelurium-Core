<?php

namespace viskaraze\Entity;

use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Location;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\world\World;

class TopMoney extends Entity
{
    protected bool $gravityEnabled = false;
    protected float $gravity = 0.0;
    public function __construct(Location $location, World $world, string $nametag)
    {
       $this->setNameTag($nametag);
       parent::__construct($location);
    }

    protected function getInitialDragMultiplier(): float
    {
        return 1;
    }

    protected function getInitialGravity(): float
    {
        return 1;
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::CHICKEN;
    }


    protected function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(0.7, 0.4);
    }

    protected function initEntity(CompoundTag $nbt): void{
        parent::initEntity($nbt);
        $this->setNameTagAlwaysVisible(true);
    }


    public function getName(): string{
        return "TopMoney";
    }

    public function isFireProof() : bool{
        return true;
    }

    public function attack(EntityDamageEvent $source) : void{
        $source->cancel();
    }
}