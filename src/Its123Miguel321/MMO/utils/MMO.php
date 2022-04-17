<?php

namespace Its123Miguel321\MMO\utils;

use pocketmine\player\Player;
use pocketmine\Server;

class MMO
{
    /** @var string $player */
    public $player;
    /** @var int $combatLVL */
    public $combatLVL = 0;
    /** @var int $combatPGS */
    public $combatPGS = 0;
    /** @var int $miningLVL */
    public $miningLVL = 0;
    /** @var int $combatPGS */
    public $miningPGS = 0;
    /** @var int $craftingLVL */
    public $craftingLVL = 0;
    /** @var int $combatPGS */
    public $craftingPGS = 0;
    /** @var int $treecuttingLVL */
    public $treecuttingLVL = 0;
    /** @var int $combatPGS */
    public $treecuttingPGS = 0;
    /** @var int $buildingLVL */
    public $buildingLVL = 0;
    /** @var int $combatPGS */
    public $buildingPGS = 0;



    /**
     * MMO constructor
     * 
     * @param string $player
     * @param array $stats
     * 
     */
    public function __construct(string $player, array $stats)
    {
        $this->player = $player;
        $this->combatLVL = $stats['CombatLevel'];
        $this->combatPGS = $stats['CombatProgress'];
        $this->miningLVL = $stats['MiningLevel'];
        $this->miningPGS = $stats['MiningProgress'];
        $this->craftingLVL = $stats['CraftingLevel'];
        $this->craftingPGS = $stats['CraftingProgress'];
        $this->treecuttingLVL = $stats['TreeCuttingLevel'];
        $this->treecuttingPGS = $stats['TreeCuttingLevel'];
        $this->buildingLVL = $stats['BuildingLevel'];
        $this->buildingPGS = $stats['BuildingProgress'];
    }



    /**
     * Gets the player name
     * 
     * @return string
     * 
     */
    public function getPlayer() : string
    {
        return $this->player;
    }



    /**
     * Gets the player if they are only
     * 
     * @return ?Player
     * 
     */
    public function getOnlinePlayer() : ?Player
    {
        return Server::getInstance()->getPlayerExact($this->getPlayer());
    }



    /**
     * Gets the level of stat
     * 
     * @param string $stat
     * 
     * @return int
     * 
     */
    public function getLevel(string $stat) : int
    {
        if(strtolower($stat) === 'combat') return $this->combatLVL;
        if(strtolower($stat) === 'mining') return $this->miningLVL;
        if(strtolower($stat) === 'crafting') return $this->craftingLVL;
        if(strtolower($stat) === 'treecutting') return $this->treecuttingLVL;
        if(strtolower($stat) === 'building') return $this->buildingLVL;

        return 0;
    }



    /**
     * Adds to the level
     * 
     * @param string $stat
     * @param int $amount
     * 
     */
    public function addLevel(string $stat, int $amount) : void
    {
        if(strtolower($stat) === 'combat') $this->combatLVL += $amount;
        if(strtolower($stat) === 'mining') $this->miningLVL += $amount;
        if(strtolower($stat) === 'crafting') $this->craftingLVL += $amount;
        if(strtolower($stat) === 'treecutting') $this->treecuttingLVL += $amount;
        if(strtolower($stat) === 'building')  $this->buildingLVL += $amount;
    }



    /**
     * Reduces the level
     * 
     * @param string $stat
     * @param int $amount
     * 
     */
    public function reduceLevel(string $stat, int $amount) : void
    {
        if(strtolower($stat) === 'combat') $this->combatLVL -= $amount;
        if(strtolower($stat) === 'mining') $this->miningLVL -= $amount;
        if(strtolower($stat) === 'crafting') $this->craftingLVL -= $amount;
        if(strtolower($stat) === 'treecutting') $this->treecuttingLVL -= $amount;
        if(strtolower($stat) === 'building')  $this->buildingLVL -= $amount;
    }



    /**
     * Sets the level
     * 
     * @param string $stat
     * @param int $amount
     * 
     */
    public function setLevel(string $stat, int $amount) : void
    {
        if(strtolower($stat) === 'combat') $this->combatLVL = $amount;
        if(strtolower($stat) === 'mining') $this->miningLVL = $amount;
        if(strtolower($stat) === 'crafting') $this->craftingLVL = $amount;
        if(strtolower($stat) === 'treecutting') $this->treecuttingLVL = $amount;
        if(strtolower($stat) === 'building')  $this->buildingLVL = $amount;
    }



    /**
     * Gets the progress
     * 
     * @param string $stat
     * 
     * @return int
     * 
     */
    public function getProgress(string $stat) : int
    {
        if(strtolower($stat) === 'combat') return $this->combatPGS;
        if(strtolower($stat) === 'mining') return $this->miningPGS;
        if(strtolower($stat) === 'crafting') return $this->craftingPGS;
        if(strtolower($stat) === 'treecutting') return $this->treecuttingPGS;
        if(strtolower($stat) === 'building') return $this->buildingPGS;

        return 0;
    }



    /**
     * Adds to the progress
     * 
     * @param string $stat
     * @param int $amount
     * 
     */
    public function addProgress(string $stat, int $amount) : void
    {
        if(strtolower($stat) === 'combat') $this->combatPGS += $amount;
        if(strtolower($stat) === 'mining') $this->miningPGS += $amount;
        if(strtolower($stat) === 'crafting') $this->craftingPGS += $amount;
        if(strtolower($stat) === 'treecutting') $this->treecuttingPGS += $amount;
        if(strtolower($stat) === 'building') $this->buildingPGS += $amount;
    }



    /**
     * Reduces the progress
     * 
     * @param string $stat
     * @param int $amount
     * 
     */
    public function reduceProgress(string $stat, int $amount) : void
    {
        if(strtolower($stat) === 'combat') $this->combatPGS -= $amount;
        if(strtolower($stat) === 'mining') $this->miningPGS -= $amount;
        if(strtolower($stat) === 'crafting') $this->craftingPGS -= $amount;
        if(strtolower($stat) === 'treecutting') $this->treecuttingPGS -= $amount;
        if(strtolower($stat) === 'building') $this->buildingPGS -= $amount;
    }



    /**
     * Sets the progress
     * 
     * @param string $stat
     * @param int $amount
     * 
     */
    public function setProgress(string $stat, int $amount) : void
    {
        if(strtolower($stat) === 'combat') $this->combatPGS = $amount;
        if(strtolower($stat) === 'mining') $this->miningPGS = $amount;
        if(strtolower($stat) === 'crafting') $this->craftingPGS = $amount;
        if(strtolower($stat) === 'treecutting') $this->treecuttingPGS = $amount;
        if(strtolower($stat) === 'building') $this->buildingPGS = $amount;
    }



    /**
     * Levels up a stat
     * 
     * @param string $stat
     * 
     */
    public function levelup(string $stat) : void
    {
        if(strtolower($stat) === 'combat')
        {
            $this->combatLVL++;
            $this->combatPGS = 0;
        }elseif(strtolower($stat) === 'mining'){
            $this->miningLVL++;
            $this->miningPGS = 0;
        }elseif(strtolower($stat) === 'crafting'){
            $this->craftingLVL++;
            $this->craftingPGS = 0;
        }elseif(strtolower($stat) === 'treecutting'){
            $this->treecuttingLVL++;
            $this->treecuttingPGS = 0;
        }elseif(strtolower($stat) === 'building'){
            $this->buildingLVL++;
            $this->buildingPGS = 0;
        }
    }
}
