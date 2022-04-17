<?php

namespace Its123Miguel321\MMO\utils;

use Its123Miguel321\MMO\Main;

use pocketmine\player\Player;
use pocketmine\utils\Config;

class MmoMessages
{
    /** @var Main $main */
    public $main;
    /** @var Config $messages */
    public $messages;

    

    /**
     * MMO messages constructor
     * 
     * @param Main $main
     * 
     */
    public function __construct(Main $main)
    {
       $this->main = $main; 
       $this->messages = new Config($main->getDataFolder() . 'messages.yml', Config::YAML);
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
     * Gets the messages config
     * 
     * @return Config
     * 
     */
    public function getMessages() : Config
    {
        return $this->messages;
    }



    /**
     * Uses str_replace to replace things in the message
     * 
     * @param string $message
     * @param $player
     * 
     * @return string
     * 
     */
    public function replace(string $message, $player = '') : string
    {
        if($player instanceof Player) $player = $player->getName();

        $stats = $this->getMain()->getManager()->getStats($player);

        $combat = 0;
        $mining = 0;
        $crafting = 0;
        $treecutting = 0;
        $building = 0;

        if($stats !== null)
        {
            $combat = $stats->getLevel('combat');
            $mining = $stats->getLevel('mining');
            $crafting = $stats->getLevel('crafting');
            $treecutting = $stats->getLevel('treecutting');
            $building = $stats->getLevel('building');
        }

        $message = str_replace([
            '&', 
            '{player}', 
            '{combat}', 
            '{mining}', 
            '{crafting}', 
            '{treecutting}', 
            '{building}'
        ], 
        [
            '§', 
            $player, 
            $combat, 
            $mining, 
            $crafting, 
            $treecutting, 
            $building
        ], 
            $message
        );

        return $message;
    }



    /**
     * Get stat level up message
     * 
     * @param string $stat
     * @param $player
     * 
     * @return string
     * 
     */
    public function getLevelUpMessage(string $stat, $player) : string
    {
        if($player instanceof Player) $player = $player->getName();

        if(strtolower($stat) === 'combat') return $this->replace($this->getMessages()->get('combat.levelup'), $player);
        if(strtolower($stat) === 'mining') return $this->replace($this->getMessages()->get('mining.levelup'), $player);
        if(strtolower($stat) === 'crafting') return $this->replace($this->getMessages()->get('crafting.levelup'), $player);
        if(strtolower($stat) === 'treecutting') return $this->replace($this->getMessages()->get('treecutting.levelup'), $player);
        if(strtolower($stat) === 'building') return $this->replace($this->getMessages()->get('building.levelup'), $player);

        return '';
    }



    /**
     * Get stat level up announcement
     * 
     * @param string $stat
     * @param $player
     * 
     * @return string
     * 
     */
    public function getLevelUpAnnouncement(string $stat, $player) : string
    {
        if($player instanceof Player) $player = $player->getName();

        if(strtolower($stat) === 'combat') return $this->replace($this->getMessages()->get('combat.levelup.announcement'), $player);
        if(strtolower($stat) === 'mining') return $this->replace($this->getMessages()->get('mining.levelup.announcement'), $player);
        if(strtolower($stat) === 'crafting') return $this->replace($this->getMessages()->get('crafting.levelup.announcement'), $player);
        if(strtolower($stat) === 'treecutting') return $this->replace($this->getMessages()->get('treecutting.levelup.announcement'), $player);
        if(strtolower($stat) === 'building') return $this->replace($this->getMessages()->get('building.levelup.announcement'), $player);

        return '';
    }



    /**
     * Checks if the level up should be announced
     * 
     * @return bool
     * 
     */
    public function announcementEnabled() : bool
    {
        return $this->getMessages()->get('level.up.announcement');
    }
}