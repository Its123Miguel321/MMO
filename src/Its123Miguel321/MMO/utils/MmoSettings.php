<?php

namespace Its123Miguel321\MMO\utils;

use Its123Miguel321\MMO\Main;

use pocketmine\player\Player;

class MmoSettings
{
    /** @var Main $main */
    public $main;

    

    /**
     * MMO settings constructor
     * 
     * @param Main $main
     * 
     */
    public function __construct(Main $main)
    {
       $this->main = $main; 
    }



    /**
     * Gets the main file
     * 
     */
    public function getMain() : Main
    {
        return $this->main;
    }



    /**
     * Gets the maximum level for a stat
     * 
     * @param string $stat
     * 
     * @return int
     * 
     */
    public function getMaxLevel(string $stat) : int
    {
        if(strtolower($stat) === 'combat') return $this->getMain()->getConfig()->get('max.combat.level');
        if(strtolower($stat) === 'mining') return $this->getMain()->getConfig()->get('max.mining.level');
        if(strtolower($stat) === 'crafting') return $this->getMain()->getConfig()->get('max.crafting.level');
        if(strtolower($stat) === 'treecutting') return $this->getMain()->getConfig()->get('max.treecutting.level');
        if(strtolower($stat) === 'building') return $this->getMain()->getConfig()->get('max.building.level');

        return 0;
    }



    /**
     * Gets the start amount for a stat
     * 
     * @param string $stat
     * 
     * @return int
     * 
     */
    public function getStartAmount(string $stat) : int
    {
        if(strtolower($stat) === 'combat') return $this->getMain()->getConfig()->get('combat.start.amount');
        if(strtolower($stat) === 'mining') return $this->getMain()->getConfig()->get('mining.start.amount');
        if(strtolower($stat) === 'crafting') return $this->getMain()->getConfig()->get('crafting.start.amount');
        if(strtolower($stat) === 'treecutting') return $this->getMain()->getConfig()->get('treecutting.start.amount');
        if(strtolower($stat) === 'building') return $this->getMain()->getConfig()->get('building.start.amount');

        return 0;
    }



    /**
     * Gets the start amount multiplier
     * 
     * @param string $stat
     * 
     * @return int
     * 
     */
    public function getStartAmountMultiplier(string $stat) : int
    {
        if(strtolower($stat) === 'combat') return $this->getMain()->getConfig()->get('combat.amount.multiplier');
        if(strtolower($stat) === 'mining') return $this->getMain()->getConfig()->get('mining.amount.multiplier');
        if(strtolower($stat) === 'crafting') return $this->getMain()->getConfig()->get('crafting.amount.multiplier');
        if(strtolower($stat) === 'treecutting') return $this->getMain()->getConfig()->get('treecutting.amount.multiplier');
        if(strtolower($stat) === 'building') return $this->getMain()->getConfig()->get('building.amount.multiplier');

        return 0;
    }



    /**
     * Gets the stat reward
     * 
     * @param string $stat
     * @param $player
     * 
     * @return string
     * 
     */
    public function getReward(string $stat, $player) : string
    {
        if($player instanceof Player) $player = $player->getName();

        if(strtolower($stat) === 'combat') return str_replace('{player}', $player, $this->getMain()->getConfig()->get('combat.levelup.reward'));
        if(strtolower($stat) === 'mining') return str_replace('{player}', $player, $this->getMain()->getConfig()->get('mining.levelup.reward'));
        if(strtolower($stat) === 'crafting') return str_replace('{player}', $player, $this->getMain()->getConfig()->get('crafting.levelup.reward'));
        if(strtolower($stat) === 'treecutting') return str_replace('{player}', $player, $this->getMain()->getConfig()->get('treecutting.levelup.reward'));
        if(strtolower($stat) === 'building') return str_replace('{player}', $player, $this->getMain()->getConfig()->get('building.levelup.reward'));

        return '';
    }



    /**
     * Gets the maximum double drop percent
     * 
     * @return float
     * 
     */
    public function getMaxDoubleDropPercent() : float
    {
        return $this->getMain()->getConfig()->get('max.doubledrop.percent');
    }



    /**
     * Gets the added double drop percent
     * 
     * @return float
     * 
     */
    public function getAddedDoubleDropPercent() : float
    {
        return $this->getMain()->getConfig()->get('added.doubledrop.percent');
    }



    /**
     * Gets the maximum extra damage percent
     * 
     * @return float
     * 
     */
    public function getMaxExtraDamagePercent() : float
    {
        return $this->getMain()->getConfig()->get('max.extradamage.percent');
    }



    /**
     * Gets the added extra damage percent
     * 
     * @return float
     * 
     */
    public function getAddedExtraDamagePercent() : float
    {
        return $this->getMain()->getConfig()->get('added.extradamage.percent');
    }



    /**
     * Gets the added extra damage percent
     * 
     * @return array
     * 
     */
    public function getAllowMiningBlocks() : array
    {
        return $this->getMain()->getConfig()->get('allowed.mining.blocks');
    }
}