<?php
namespace viskaraze\Utils;

use viskaraze\API\NexusAPI;

class ApiManager
{
    public NexusAPI $nexusAPI;

    public function getNexusApi()
    {
        return $this->nexusAPI;
    }
}