<?php

namespace Its123Miguel321\MMO;

use Its123Miguel321\MMO\API\MmoAPI;
use Its123Miguel321\MMO\commands\SeeMmo;
use Its123Miguel321\MMO\EventListener;
use Its123Miguel321\MMO\manager\MmoManager;
use Its123Miguel321\MMO\utils\MmoMessages;
use Its123Miguel321\MMO\utils\MmoSettings;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    /** @var self $instance */
    public static $instance;
    /** @var MmoManager $manager */
    public $manager;
    /** @var MmoAPI $api */
    public $api;
    /** @var MmoSettings $settings */
    public $settings;
    /** @var MmoMessages $messages */
    public $messages;



    /**
     * What happens when the plugin is enabled
     * 
     * Registers the commands
     * Registers the event listener
     * Sets the manager
     * Sets the api
     * Sets the settings
     * Sets the messages
     * 
     */
    public function onEnable() : void
    {
        self::$instance = $this;

        $this->saveResource('config.yml');
        $this->saveResource('messages.yml');

        $this->api = new MmoAPI($this);
        $this->manager = new MmoManager($this);
        $this->messages = new MmoMessages($this);
        $this->settings = new MmoSettings($this);

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getCommandMap()->registerAll('MMO', [new SeeMmo($this)]);
    }



    /**
     * What happens when the plugin is disabled
     * 
     * Saves all mmo stats
     * 
     */
    public function onDisable() : void
    {
        $this->getManager()->saveAllStats();
    }



    /**
     * Gets the api
     * 
     * @return MmoAPI
     * 
     */
    public function getApi() : MmoAPI
    {
        return $this->api;
    }



    /**
     * Gets the manager
     * 
     * @return MmoManager
     * 
     */
    public function getManager() : MmoManager
    {
        return $this->manager;
    }



    /**
     * Gets the messages
     * 
     * @return MmoMessages
     * 
     */
    public function getMessages() : MmoMessages
    {
        return $this->messages;
    }



    /**
     * Gets the manager
     * 
     * @return MmoSettings
     * 
     */
    public function getSettings() : MmoSettings
    {
        return $this->settings;
    }
    
    
    
    /**
     * Returns itself
     *
     * @return self
     *
     */
    public static function getInstance() : self
    {
        return self::$instance;
    }
}
