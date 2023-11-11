<?php
namespace viskaraze;

use customiesdevs\customies\block\{CustomiesBlockFactory,
    Material,
    Model
};

use customiesdevs\customies\item\CreativeInventoryInfo;
use pocketmine\block\{BlockBreakInfo,
    BlockTypeIds,
    BlockTypeInfo,
    BlockIdentifier as BI
};
use pocketmine\math\Vector3;
use viskaraze\blocks\MineraisFluorine;
use viskaraze\blocks\MineraisSodalite;
use viskaraze\blocks\TerreFertile;
use viskaraze\Utils\BlockIdentifier;

class BlockLoader {

    public function __construct()
    {
        $this->initBlocks();
    }

    private function initBlocks(): void {
        // Terre fertile
        $id = BlockTypeIds::newId();
        CustomiesBlockFactory::getInstance()->registerBlock(
            static fn() => new TerreFertile(new BI($id), "terre_fertile", new BlockTypeInfo(new BlockBreakInfo(0.3))), // BlockBreakInfo = vitesse cassage (indé. de l'outil)
            BlockIdentifier::TERRE_FERTILE,
            new Model(
                [
                    new Material(Material::TARGET_ALL, "terre_fertile", Material::RENDER_METHOD_ALPHA_TEST)
                ],
                "geometry.block",
                new Vector3(-8, 0, -8),
                new Vector3(16, 16, 16),
            ),
            new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_ITEMS, CreativeInventoryInfo::NONE)
        );

        // Minerais Fluorine
        $id = BlockTypeIds::newId();
        CustomiesBlockFactory::getInstance()->registerBlock(
            static fn() => new MineraisFluorine(new BI($id), "minerais_fluorine", new BlockTypeInfo(new BlockBreakInfo(0.3))), // BlockBreakInfo = vitesse cassage (indé. de l'outil)
            BlockIdentifier::MINERAIS_FLUORINE,
            new Model(
                [
                    new Material(Material::TARGET_ALL, "minerais_fluorine", Material::RENDER_METHOD_ALPHA_TEST)
                ],
                "geometry.block",
                new Vector3(-8, 0, -8),
                new Vector3(16, 16, 16),
            ),
            new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_ITEMS, CreativeInventoryInfo::NONE)
        );
        // Minerais Sodalite
        $id = BlockTypeIds::newId();
        CustomiesBlockFactory::getInstance()->registerBlock(
            static fn() => new MineraisSodalite(new BI($id), "minerais_sodalite", new BlockTypeInfo(new BlockBreakInfo(0.3))), // BlockBreakInfo = vitesse cassage (indé. de l'outil)
            BlockIdentifier::MINERAIS_SODALITE,
            new Model(
                [
                    new Material(Material::TARGET_ALL, "minerais_sodalite", Material::RENDER_METHOD_ALPHA_TEST)
                ],
                "geometry.block",
                new Vector3(-8, 0, -8),
                new Vector3(16, 16, 16),
            ),
            new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_ITEMS, CreativeInventoryInfo::NONE)
        );
    }     
}