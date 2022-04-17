<?php

namespace Its123Miguel321\MMO\API;

use Its123Miguel321\MMO\Main;

use pocketmine\player\Player;

class MmoAPI
{
    /** @var Main $main */
    public $main;



    /**
     * The MMO manager constructor
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
     * @return Main
     * 
     */
    public function getMain() : Main
    {
        return $this->main;
    }



    /**
     * Checks if the player can level up
     * 
     * @param $player
     * @param string $stat
     * 
     * @return bool
     * 
     */
    public function canLevelup($player, string $stat) : bool
    {
        if($player instanceof Player) $player = $player->getName();

        $stats = $this->getMain()->getManager()->getStats($player);

        if($stats === null) return false;

        $progress = 0;

        if(strtolower($stat) === 'combat')
        {
            $progress = $stats->getProgress('combat');
        }elseif(strtolower($stat) === 'mining'){
            $progress = $stats->getProgress('mining');
        }elseif(strtolower($stat) === 'crafting'){
            $progress = $stats->getProgress('crafting');
        }elseif(strtolower($stat) === 'treecutting'){
            $progress = $stats->getProgress('treecutting');
        }elseif(strtolower($stat) === 'building'){
            $progress = $stats->getProgress('building');
        }

        if($this->getMaxProgress($player, $stat) === 0) return false;

        return ($progress >= $this->getMaxProgress($player, $stat));
    }


    /**
     * Gets the max progress for that level
     * 
     * @param $player
     * @param string $stat
     * 
     * @return int
     * 
     */
    public function getMaxProgress($player, string $stat) : int
    {
        if($player instanceof Player) $player = $player->getName();

        $stats = $this->getMain()->getManager()->getStats($player);

        if($stats === null) return 0;

        $start = 0;
        $multiplier = 1.0;
        $level = 1;

        if(strtolower($stat) === 'combat')
        {
            $start = $this->getMain()->getSettings()->getStartAmount('combat');
            $multiplier = $this->getMain()->getSettings()->getStartAmountMultiplier('combat');
            $level += $stats->getLevel('combat');
        }elseif(strtolower($stat) === 'mining'){
            $start = $this->getMain()->getSettings()->getStartAmount('mining');
            $multiplier = $this->getMain()->getSettings()->getStartAmountMultiplier('mining');
            $level += $stats->getLevel('mining');
        }elseif(strtolower($stat) === 'crafting'){
            $start = $this->getMain()->getSettings()->getStartAmount('crafting');
            $multiplier = $this->getMain()->getSettings()->getStartAmountMultiplier('crafting');
            $level += $stats->getLevel('crafting');
        }elseif(strtolower($stat) === 'treecutting'){
            $start = $this->getMain()->getSettings()->getStartAmount('treecutting');
            $multiplier = $this->getMain()->getSettings()->getStartAmountMultiplier('treecutting');
            $level += $stats->getLevel('treecutting');
        }elseif(strtolower($stat) === 'building'){
            $start = $this->getMain()->getSettings()->getStartAmount('building');
            $multiplier = $this->getMain()->getSettings()->getStartAmountMultiplier('building');
            $level += $stats->getLevel('building');
        }

        return (int)($multiplier * $start * $level);
    }



    /**
     * Gets the double drop chance
     * 
     * @param $player
     * 
     * @return bool
     * 
     */
    public function canDoubleDrop($player) : bool
    {
        $stats = $this->getMain()->getManager()->getStats($player);
        $level = 1;

        if($stats !== null) $level += $stats->getLevel('mining');

        if($level * $this->getMain()->getSettings()->getAddedDoubleDropPercent() === 0) return false;

        return (mt_rand(1, 100) <= $level * $this->getMain()->getSettings()->getAddedDoubleDropPercent());
    }



    /**
     * Gets the extra damage chance
     * 
     * @param $player
     * 
     * @return bool
     * 
     */
    public function canDoExtraDamage($player) : bool
    {
        $stats = $this->getMain()->getManager()->getStats($player);
        $level = 1;

        if($stats !== null) $level += $stats->getLevel('combat');

        if($level * $this->getMain()->getSettings()->getAddedExtraDamagePercent() === 0) return false;

        return (mt_rand(1, 100) <= $level * $this->getMain()->getSettings()->getAddedExtraDamagePercent());
    }
}
