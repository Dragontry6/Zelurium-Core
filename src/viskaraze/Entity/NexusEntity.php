<?php

namespace viskaraze\Entity;

use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\StringToEnchantmentParser;
use pocketmine\item\StringToItemParser;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\world\particle\ExplodeParticle;
use pocketmine\world\sound\ExplodeSound;
use viskaraze\zCore;
use pocketmine\player\Player;
use pocketmine\Server;
use viskaraze\Manager;

class NexusEntity extends Entity {

    private $nexus_maxhealth;
    private $cooldown;

    public static function getNetworkTypeId(): string{ return EntityIds::ENDER_CRYSTAL; }

    protected function getInitialDragMultiplier(): float
    {
        return 1;
    }

    protected function getInitialGravity(): float
    {
        return 1;
    }

    protected function getInitialSizeInfo(): EntitySizeInfo{ return new EntitySizeInfo(1.8, 0.6, 1.62);}

    protected function initEntity(CompoundTag $nbt): void{
        parent::initEntity($nbt);
        $this->nexus_maxhealth = 10000;
        $this->setNameTagAlwaysVisible(true);
      //  $this->setImmobile(true);
        $this->setMaxHealth(10000);
        $this->setHealth(10000);
        $this->setHasGravity(false);
        $this->setNameTag(str_replace(["{health}", "{max_health}"], [$this->getHealth(), $this->nexus_maxhealth], "§6Nexus\n§7[§6{health} §7/ §6{max_health}§7]"));
    }
    public function getName(): string{
       return "NexusEvent";
    }

    public function onUpdate(int $currentTick): bool
    {
        $this->setNameTag(str_replace(["{health}", "{max_health}"], [$this->getHealth(), $this->nexus_maxhealth], "§6Nexus\n§7[§6{health} §7/ §6{max_health}"));
        return parent::onUpdate($currentTick);
    }

    public function attack(EntityDamageEvent $source): void
    {
        if($source instanceof EntityDamageByEntityEvent) {
            if ($source->getDamager() instanceof Player) {

                //if($this->cooldown - time() <= 0){


                    if ($this->getHealth() == $this->nexus_maxhealth / 2 + 1) {
                        Server::getInstance()->broadcastMessage(Manager::Prefix . "Le §6Nexus §7est à la §6moitié §7de sa vie !");
                    }

                    if ($this->getHealth() == $this->nexus_maxhealth / 4 + 1) {
                        Server::getInstance()->broadcastMessage(Manager::Prefix . "Le §6Nexus §7est à un §6quart §7de sa vie !");
                    }

                    if ($this->getHealth() <= 1) {
                        Server::getInstance()->broadcastMessage(str_replace("{player}", $source->getDamager()->getName(), Manager::Prefix . "Le §6Nexus §7a été §6tué §7par §6{player} §7courez récupérer le stuff !"));
                        $this->kill();
                        $this->flagForDespawn();
                        $this->close();
                        $this->dropItem();
                        return;
                    }
                    $this->setHealth($this->getHealth()-1);
                    //$this->cooldown = time() + 0.00001;
                //}
            }
        }
    }


    public function dropItem(){
        $items = zCore::getInstance()->getConfig()->getNested("Nexus-Settings.Reward.Item");
        foreach($items as $it => $item){
            $exp = explode(",", $item);
            $itemCount = (int)$exp[1];
            for ($i = 0; $i < $itemCount; $i++){
                $drop = StringToItemParser::getInstance()->parse($exp[0]);
                $drop->setCount((int)$exp[1]);
                if(isset($exp[2]) && isset($exp[3])){
                    $drop->addEnchantment(new EnchantmentInstance(StringToEnchantmentParser::getInstance()->parse($exp[2]), $exp[3]));
                }


                $pitch = mt_rand(-20, 0);
                $yaw = mt_rand(0, 360);
                $d = zCore::getInstance()->getConfig()->getNested("Nexus-Settings.Reward.drop-distance");
                $h = zCore::getInstance()->getConfig()->getNested("Nexus-Settings.Reward.drop-height");
                $motion = new Vector3((-sin($yaw / 180 * M_PI) * cos($pitch / 180 * M_PI)) * $d, -sin($pitch / 180 * M_PI) * $h, (cos($yaw / 180 * M_PI) * cos($pitch / 180 * M_PI)) * $d);
                $this->getWorld()->addSound($this->getPosition()->add(0.5, 0.5, 0.5), new ExplodeSound());
                $this->getWorld()->addParticle($this->getPosition()->add(0.5, 0.5, 0.5), new ExplodeParticle());
                $this->getWorld()->dropItem(new Vector3($this->getLocation()->x, $this->getLocation()->y, $this->getLocation()->z), $drop, $motion);
            }
        }
    }

}
