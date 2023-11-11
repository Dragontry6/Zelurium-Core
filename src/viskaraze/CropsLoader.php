<?php
namespace viskaraze;

use customiesdevs\customies\block\{CustomiesBlockFactory,
    Material,
    Model
};
use pocketmine\block\{BlockBreakInfo,
    BlockTypeIds,
    BlockTypeInfo,
    BlockIdentifier
};
use pocketmine\math\Vector3;
use pocketmine\Server;
use viskaraze\crops\zelurite;
use viskaraze\Utils\CropsIdentifier;

class CropsLoader {

    public function __construct() {
        self::registerCustomCrops(zelurite::class, CropsIdentifier::ZELU_CROP, "geometry.crop.hash");
    }

    public static function registerCustomCrops(string $class, string $ids, string $geometry, int $stages = 5): void {
        $stageNumber = [];
        for ($i = 0; $i < $stages; ++$i) {
            $stageNumber[] = $i;
        }

        foreach ($stageNumber as $variant) {
            $id = BlockTypeIds::newId();
            $material = new Material(Material::TARGET_ALL, str_replace(CropsIdentifier::PREFIX, "", $ids) . "_" . $variant, Material::RENDER_METHOD_ALPHA_TEST, true, true);
            $model = new Model([$material], $geometry, new Vector3(-8, 0, -8), new Vector3(16, 16, 16), 0);

            CustomiesBlockFactory::getInstance()->registerBlock(
                static fn() => new $class(new BlockIdentifier($id), str_replace(CropsIdentifier::PREFIX, "", $ids) . "_" . $variant, new BlockTypeInfo(new BlockBreakInfo(0))),
                $ids . "_" . $variant,
                $model,
                null
            );

            foreach (Server::getInstance()->getWorldManager()->getWorlds() as $world) {
                $world->addRandomTickedBlock(CustomiesBlockFactory::getInstance()->get($ids . "_" . $variant));
            }
        }
    }
}