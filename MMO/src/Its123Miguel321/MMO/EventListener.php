<?php

namespace Its123Miguel321\MMO;

use Its123Miguel321\MMO\Main;

use pocketmine\console\ConsoleCommandSender;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\item\ItemFactory;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\Server;

class EventListener implements Listener
{
    /** @var Main $main */
    public $main;



    /**
     * EventListener constructor
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
     * Opens stats
     * 
     * @param PlayerLoginEvent $event
     * 
     */
    public function onLogin(PlayerLoginEvent $event) : void
    {
        $player = $event->getPlayer();

        if(!($this->getMain()->getManager()->isRegistered($player)))
        {
            $this->getMain()->getManager()->createStats($player);
        }else{
            $this->getMain()->getManager()->openStats($player);
        }


    }



    /**
     * Adds to the mining and treecutting stats
     * 
     * @param BlockBreakEvent $event
     * 
     */
    public function onBreak(BlockBreakEvent $event) : void
    {
        if($event->isCancelled()) return;

        $player = $event->getPlayer();

        if($player->getGamemode() === GameMode::CREATIVE()) return;

        $block = $event->getBlock();
        $tree = ['17:0', '17:1', '17:2', '17:3', '162:0', '162:1'];

        if(in_array($block->getId() . ':' . $block->getMeta(), $this->getMain()->getSettings()->getAllowMiningBlocks()))
        {
            $stats = $this->getMain()->getManager()->getStats($player);
            $stats->addProgress('mining', 1);

            if($this->getMain()->getApi()->canLevelup($player, 'mining'))
            {
                $stats->levelup('mining');
                $player->sendMessage($this->getMain()->getMessages()->getLevelUpMessage('mining', $player));

                Server::getInstance()->getCommandMap()->dispatch(
                    new ConsoleCommandSender(Server::getInstance(), Server::getInstance()->getLanguage()), 
                    $this->getMain()->getSettings()->getReward('mining', $player)
                );

                if($this->getMain()->getMessages()->announcementEnabled()) Server::getInstance()->broadcastMessage($this->getMain()->getMessages()->getLevelUpAnnouncement('mining', $player));
            }

            if($this->getMain()->getApi()->canDoubleDrop($player))
            {
                $drops = [];

                foreach($event->getDrops() as $drop)
                {
                    $drops[] = ItemFactory::getInstance()->get($drop->getId(), $drop->getMeta(), 2);
                }

                $event->setDrops($drops);

                $player->sendMessage($this->getMain()->getMessages()->replace($this->getMain()->getMessages()->getMessages()->get('doubledrop.message')));
            }

            return;
        }elseif(in_array($block->getId() . ':' . $block->getMeta(), $tree))
        {
            $stats = $this->getMain()->getManager()->getStats($player);
            $stats->addProgress('treecutting', 1);

            if($this->getMain()->getApi()->canLevelup($player, 'treecutting'))
            {
                $stats->levelup('treecutting');
                $player->sendMessage($this->getMain()->getMessages()->getLevelUpMessage('treecutting', $player));

                Server::getInstance()->getCommandMap()->dispatch(
                    new ConsoleCommandSender(Server::getInstance(), Server::getInstance()->getLanguage()), 
                    $this->getMain()->getSettings()->getReward('treecutting', $player)
                );

                if($this->getMain()->getMessages()->announcementEnabled()) Server::getInstance()->broadcastMessage($this->getMain()->getMessages()->getLevelUpAnnouncement('treecutting', $player));
            }

            return;
        }
    }



    /**
     * Adds to building stats
     * 
     * @param BlockPlaceEvent $event
     * 
     */
    public function onPlace(BlockPlaceEvent $event) : void
    {
        if($event->isCancelled()) return;

        $player = $event->getPlayer();

        if($player->getGamemode() === GameMode::CREATIVE()) return;

        $stats = $this->getMain()->getManager()->getStats($player);
        $stats->addProgress('building', 1);

        if($this->getMain()->getApi()->canLevelup($player, 'building'))
        {
            $stats->levelup('building');
            $player->sendMessage($this->getMain()->getMessages()->getLevelUpMessage('building', $player));

            Server::getInstance()->getCommandMap()->dispatch(
                new ConsoleCommandSender(Server::getInstance(), Server::getInstance()->getLanguage()), 
                $this->getMain()->getSettings()->getReward('building', $player)
            );

            if($this->getMain()->getMessages()->announcementEnabled()) Server::getInstance()->broadcastMessage($this->getMain()->getMessages()->getLevelUpAnnouncement('building', $player));
        }
    }



    /**
     * Adds to crafting stats
     * 
     * @param CraftItemEvent $event
     * 
     */
    public function onCraft(CraftItemEvent $event) : void
    {
        if($event->isCancelled()) return;

        $player = $event->getPlayer();

        if($player->getGamemode() === GameMode::CREATIVE()) return;

        $stats = $this->getMain()->getManager()->getStats($player);
        $stats->addProgress('crafting', 1);

        if($this->getMain()->getApi()->canLevelup($player, 'crafting'))
        {
            $stats->levelup('crafting');
            $player->sendMessage($this->getMain()->getMessages()->getLevelUpMessage('crafting', $player));

            Server::getInstance()->getCommandMap()->dispatch(
                new ConsoleCommandSender(Server::getInstance(), Server::getInstance()->getLanguage()), 
                $this->getMain()->getSettings()->getReward('crafting', $player)
            );

            if($this->getMain()->getMessages()->announcementEnabled()) Server::getInstance()->broadcastMessage($this->getMain()->getMessages()->getLevelUpAnnouncement('crafting', $player));
        }
    }



    /**
     * Adds to crafting stats
     * 
     * @param PlayerDeathEvent $event
     * 
     */
    public function onDeath(PlayerDeathEvent $event) : void
    {
        $player = $event->getPlayer();
        $cause = $player->getLastDamageCause();

        if(!($cause instanceof EntityDamageByEntityEvent)) return;

        $attacker = $cause->getDamager();

        if(!($attacker instanceof Player)) return;
        if($attacker->getGamemode() === GameMode::CREATIVE()) return;

        $stats = $this->getMain()->getManager()->getStats($attacker);
        $stats->addProgress('combat', 1);

        if($this->getMain()->getApi()->canLevelup($attacker, 'combat'))
        {
            $stats->levelup('combat');
            $attacker->sendMessage($this->getMain()->getMessages()->getLevelUpMessage('combat', $attacker));

            Server::getInstance()->getCommandMap()->dispatch(
                new ConsoleCommandSender(Server::getInstance(), Server::getInstance()->getLanguage()), 
                $this->getMain()->getSettings()->getReward('combat', $attacker)
            );

            if($this->getMain()->getMessages()->announcementEnabled()) Server::getInstance()->broadcastMessage($this->getMain()->getMessages()->getLevelUpAnnouncement('combat', $attacker));
        }
    }



    /**
     * Does the extra damage
     * 
     * @param EntityDamageByEntityEvent $event
     * 
     */
    public function onAttack(EntityDamageByEntityEvent $event) : void
    {
        if($event->isCancelled())

        $victim = $event->getEntity();
        $attacker = $event->getDamager();

        if(!($attacker instanceof Player)) return;
        if(!($this->getMain()->getApi()->canDoExtraDamage($attacker))) return;

        $event->setBaseDamage($event->getBaseDamage() * 1.5);
        $attacker->sendMessage($this->getMain()->getMessages()->replace($this->getMain()->getMessages()->getMessages()->get('extradamage.message')));
    }
}