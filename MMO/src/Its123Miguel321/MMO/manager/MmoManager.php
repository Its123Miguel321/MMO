<?php

namespace Its123Miguel321\MMO\manager;

use Its123Miguel321\MMO\Main;
use Its123Miguel321\MMO\utils\MMO;

use pocketmine\player\Player;
use pocketmine\utils\Config;

class MmoManager
{
    /** @var Main $main */
    public $main;
    /** @var Config $config */
    public $config;
    /** @var array $data */
    public $data = [];



    /**
     * The MMO manager constructor
     * 
     * @param Main $main
     * 
     */
    public function __construct(Main $main)
    {
        $this->main = $main;

        @mkdir($main->getDataFolder() . 'data');
        $this->config = new Config($main->getDataFolder() . 'data/data.yml', Config::YAML);
    }



    /**
     * Gets the main file
     * 
     * @return Main
     * 
     */
    public function getMain() : Main
    {
        return $this->main;
    }



    /**
     * Gets the config
     * 
     * @return Config
     * 
     */
    public function getConfig() : Config
    {
        return $this->config;
    }



    /**
     * Gets all data
     * 
     * @return array
     * 
     */
    public function getData() : array
    {
        return $this->data;
    }



    /**
     * Checks if the player has any data in the config or in the array
     * 
     * @param $player
     * 
     */
    public function isRegistered($player) : bool
    {
        if($player instanceof Player) $player = $player->getName();

        $config = $this->getConfig()->get('stats', []);

        if(isset($config[$player]) || isset($this->data[$player]))
        {
            return true;
        }

        return false;
    }



    /**
     * Creates stats for a player without any
     * 
     * @param $player
     * 
     */
    public function createStats($player) : void
    {
        if($player instanceof Player) $player = $player->getName();
        if($this->isRegistered($player)) return;

        $this->data[$player] = new MMO($player, [
            'CombatLevel' => 0,
            'CombatProgress' => 0,
            'MiningLevel' => 0,
            'MiningProgress' => 0,
            'CraftingLevel' => 0,
            'CraftingProgress' => 0,
            'TreeCuttingLevel' => 0, 
            'TreeCuttingProgress' => 0,
            'BuildingLevel' => 0,
            'BuildingProgress' => 0
        ]);
    }



    /**
     * Deletes/unregisters stats of a player
     * 
     * @param $player
     * 
     */
    public function deleteStats($player) : void
    {
        if($player instanceof Player) $player = $player->getName();

        $config = $this->getConfig()->get('stats', []);

        if(isset($config[$player]))
        {
            unset($config[$player]);
        }
        
        if(isset($this->data[$player]))
        {
            unset($this->data[$player]);
        }
    }



    /**
     * Opens a player's stats
     * 
     * @param $player
     * 
     */
    public function openStats($player) : void
    {
        if($player instanceof Player) $player = $player->getName();
        if($this->isRegistered($player) && isset($this->data[$player])) return;

        $this->data[$player] = $this->getStats($player);
    }



    /**
     * Gets the stats of a player
     * 
     * @param $player
     * 
     * @return ?MMO
     * 
     */
    public function getStats($player) : ?MMO
    {
        if($player instanceof Player) $player = $player->getName();

        $config = $this->getConfig()->get('stats', []);

        if($this->isRegistered($player) && !(isset($this->data[$player])))
        {
            return new MMO($player, [
                'CombatLevel' => $config[$player]['CombatLevel'],
                'CombatProgress' => $config[$player]['CombatProgress'],
                'MiningLevel' => $config[$player]['MiningLevel'],
                'MiningProgress' => $config[$player]['MiningProgress'],
                'CraftingLevel' => $config[$player]['CraftingLevel'],
                'CraftingProgress' => $config[$player]['CraftingProgress'],
                'TreeCuttingLevel' => $config[$player]['TreeCuttingLevel'], 
                'TreeCuttingProgress' => $config[$player]['TreeCuttingProgress'],
                'BuildingLevel' => $config[$player]['BuildingLevel'],
                'BuildingProgress' => $config[$player]['BuildingProgress']
            ]);
        }elseif($this->isRegistered($player) && !(isset($config[$player]))){
            return $this->data[$player];
        }elseif($this->isRegistered($player)){
            return $this->data[$player];
        }

        return null;
    }



    /**
     * Saves everyone's data
     * 
     */
    public function saveAllStats() : void
    {
        foreach($this->data as $mmo)
        {
            $this->saveStats($mmo->getPlayer(), [
                'CombatLevel' => $mmo->getLevel('combat'),
                'CombatProgress' => $mmo->getProgress('combat'),
                'MiningLevel' => $mmo->getLevel('mining'),
                'MiningProgress' => $mmo->getProgress('mining'),
                'CraftingLevel' => $mmo->getLevel('crafting'),
                'CraftingProgress' => $mmo->getProgress('crafting'),
                'TreeCuttingLevel' => $mmo->getLevel('treecutting'), 
                'TreeCuttingProgress' => $mmo->getProgress('treecutting'),
                'BuildingLevel' => $mmo->getLevel('building'),
                'BuildingProgress' => $mmo->getProgress('building')
            ]);
        }
    }



    /**
     * Saves stats
     * 
     */
    public function saveStats($player, array $stats) : void
    {
        $config = $this->getConfig()->get('stats', []);
        $config[$player] = $stats;
        
        $this->getConfig()->set('stats', $config);
        $this->getConfig()->save();
    }
}