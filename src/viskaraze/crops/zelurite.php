<?php

namespace viskaraze\crops;

use customiesdevs\customies\block\CustomiesBlockFactory;
use customiesdevs\customies\item\CustomiesItemFactory;
use pocketmine\block\BlockTypeInfo;
use pocketmine\item\Item;
use viskaraze\crops\manager\Crops2;
use viskaraze\Utils\CropsIdentifier;

class zelurite extends Crops2
{

    public function __construct($idInfo, string $name, BlockTypeInfo $typeInfo)
    {
        parent::__construct($idInfo, $name, $typeInfo, CropsIdentifier::ZELU_CROP);
    }

    public function getHardness(): float
    {
        return -1;
    }

    public function getDropsForCompatibleTool(Item $item): array
    {
        if ($this->getTypeId() == CustomiesBlockFactory::getInstance()->get(CropsIdentifier::ZELU_CROP . "_2")->getTypeId()) {
            $rand = rand(1, 600);
            if ($rand === 1) {
                return [
                    CustomiesItemFactory::getInstance()->get("customies:fragment_zelurite")
                ];
            } else {
                $rand = rand(1, 3);
                if ($rand === 1) {
                    return [
                        CustomiesItemFactory::getInstance()->get("customies:graines_zelurite")
                    ];
                } else {
                    return [];
                }
            }
        } else {
            return [
                CustomiesItemFactory::getInstance()->get("customies:graines_zelurite")
            ];
        }
    }
}
