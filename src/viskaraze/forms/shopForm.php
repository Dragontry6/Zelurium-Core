<?php

namespace viskaraze\forms;

use onebone\economyapi\EconomyAPI;
use pocketmine\item\StringToItemParser;
use pocketmine\player\Player;
use pocketmine\utils\StringToTParser;
use Vecnavium\FormsUI\CustomForm;
use Vecnavium\FormsUI\SimpleForm;
use viskaraze\API\shopUI;
use viskaraze\commands\player\all\shop;
use viskaraze\Manager;

class shopForm
{

    public static function addItemInShop(Player $player)
    {
        $form = new CustomForm(function (Player $player, $data){
            if($data === null){
                return true;
            }

            if($data[0] === null) return;
            if($data[1] === null || !is_numeric($data[1])) return;
            if($data[2] === null || !is_numeric($data[2])) return;

            $item = $player->getInventory()->getItemInHand();
            $nameitem = StringToItemParser::getInstance()->lookupAliases($item);
            $nameitem = $nameitem[0];
            if(shopUI::getItemExist($nameitem)){
                $player->sendMessage(Manager::Prefix . "L'item existe déjà !");
            }
            if(!shopUI::getItemExist($nameitem)){
                shopUI::registerNewItem($nameitem, $data[0], $data[3], $data[1], $data[2]);
                $player->sendMessage(Manager::Prefix . "L'item a bien été enregistré !");
            }

        });

        $form->setTitle(Manager::Prefix . "AddShop");
        $form->addInput("Label");
        $form->addInput("$ Achat");
        $form->addInput("$ Vente");
        $form->addDropdown("Catégorie", shopUI::getAllCategory());
        $form->sendToPlayer($player);
    }

    public static function OpenShopUi(Player $player) :void
    {
        $form = new SimpleForm(function (Player $player, $data){
           if($data === null) {
               return true;
           }
        shopUI::openCategory($player, $data);
        });

        $allCategorie = shopUI::getAllCategory();
        $form->setTitle("Exemple title");
        $form->setContent("Exemple label");
        foreach ($allCategorie as $category) {
            $form->addButton("§7§l= §r§6" . $category . " §7§l=", SimpleForm::IMAGE_TYPE_PATH, "textures/blocks/sodalite_ore");
        }
        $form->setTitle(Manager::Prefix . "Shop");
        $form->sendToPlayer($player);
    }

    public static function OpenShopUiCategorie(Player $player, string $category) :void{
        $form = new SimpleForm(function (Player $player, $data) use ($category){
            if($data === null) {
                return true;
            }
            shopForm::OpenShopUiItem($player, $data, $category);
        });

        $allcat = shopUI::getAllCategory();
        $allitem = shopUI::getAllItems();
        foreach ($allitem as $item) {
            if ($item["category"] === "$category"){
                $form->addButton($item["label"]);
            }
        }

        $form->setTitle(Manager::Prefix . $allcat[$category]);
        $form->sendToPlayer($player);
    }

    public static function OpenShopUiItem(Player $player, int $itemchoisi, int $cat) :void{
        $allitem = shopUI::getAllItems();
        $itemCat = [];
        foreach ($allitem as $item) {
            if($item["category"] === "$cat"){
                array_push($itemCat, $item);
            }
        }

        foreach ($itemCat as $item => $itemNum) {
            $itemCat = $itemNum;
        }

        $form = new CustomForm(function (Player $player, $data) use ($itemCat) {
            if($data === null) {
                return true;
            }
            if(!is_numeric($data[5])){
                $player->sendMessage(Manager::Prefix . "La quantité doit être numérique & doit être un entier !");
            } else {
                $quantity = (int)$data[5];
                $item = StringToItemParser::getInstance()->parse($itemCat["stringNameItem"]);
                $item->setCount($quantity);
                if($data[4]){
                    if($player->getInventory()->contains($item)){
                        $totalPriceSell = $itemCat["prixVente"] * $quantity;
                        $player->getInventory()->removeItem($item);
                        EconomyAPI::getInstance()->addMoney($player, $totalPriceSell);
                        $player->sendMessage(Manager::Prefix . "Vous avez bien vendu ceci pour §6" . $totalPriceSell . "$");
                    } else {
                        $player->sendMessage(Manager::ErrorPrefix . "Vous n'avez pas cet item dans votre inventaire !");
                    }

                } else {
                    if (EconomyAPI::getInstance()->myMoney($player) >= ($itemCat["prixAchat"] * $quantity)) {
                        EconomyAPI::getInstance()->reduceMoney($player, $itemCat["prixAchat"] * $quantity);
                        $player->getInventory()->addItem($item);
                        $player->sendMessage(Manager::Prefix . "Vous avez bien acheté ceci pour §6" . $itemCat["prixAchat"] * $quantity . "$ !");
                    } else {
                        $player->sendMessage(Manager::ErrorPrefix . "Vous n'avez pas assez d'argent !");
                    }
                }
            }

        });

        $allitem = shopUI::getAllItems();
        $itemCat = [];
        foreach ($allitem as $item) {
            if($item["category"] === "$cat"){
                array_push($itemCat, $item);
            }
        }
            $totalcount = 0;
        foreach ($itemCat as $item => $itemNum){
            if($item === $itemchoisi){
                $inventory = $player->getInventory()->getContents();
                foreach ($inventory as $itemInv){
                    $itemNameVanilla = StringToItemParser::getInstance()->lookupAliases($itemInv);
                    $itemNameVanilla = $itemNameVanilla[0];
                    if($itemNameVanilla === $itemNum["stringNameItem"]){
                        $totalcount = $totalcount + $itemInv->getCount();
                    }
                }
                $form->setTitle(Manager::Prefix . $itemNum["label"]);
                $form->addLabel("§6Vous avez §7" . $totalcount . " " . $itemNum["label"]. " §6sur vous !");
                $form->addLabel("§6Item §l»§r§7 " . $itemNum["label"]);
                $form->addLabel("§aAchat §l»§r§7 " . $itemNum["prixAchat"] . "$");
                $form->addLabel("§cVente §l»§r§7 " . $itemNum["prixVente"] . "$");
                $form->addToggle("Achat/Vente");
                $form->addInput("Quantité");
            }
        }

        $form->setTitle(Manager::Prefix);
        $form->sendToPlayer($player);
    }
}