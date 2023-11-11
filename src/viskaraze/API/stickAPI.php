<?php

namespace viskaraze\API;

use viskaraze\Utils\ConfigManager;

class stickAPI
{

    /**
     * Allows you to have all the sticks in an array.
     *
     * @return array
     */
    public function getAllStick(): array{
        return ConfigManager::getConfigStick()->getAll();
    }

    /**
     * Allows to have a stick thanks to an id "id:meta".
     *
     * @param string $string
     * @return array
     */
    public function getStickFromString(string $string): array{
        return ConfigManager::getConfigStick()->get($string);
    }


    /**
     * Gives you all the effects of a stick.
     *
     * @param string $string
     * @return array
     */
    public function getAllEffectFromStick(string $string): array{
        return ConfigManager::getConfigStick()->get($string)['effect'];
    }


    /**
     * Lets you know if a stick has permission.
     *
     * @param string $stick
     * @return bool
     */
    public function hasPermInStick(string $stick): bool{
        if (array_key_exists('permission', ConfigManager::getConfigStick()->get($stick))){
            if (ConfigManager::getConfigStick()->get($stick)['permission']['enable']) return true;
        }
        return false;
    }


    /**
     * Lets know the permission of a stick.
     * /!\ CAREFUL ! (Check if the stick has permission before.)
     *
     * @param string $stick
     * @return string
     */
    public function getPermissionInStick(string $stick): string{
        return ConfigManager::getConfigStick()->get($stick)['permission']['perm'];
    }
}