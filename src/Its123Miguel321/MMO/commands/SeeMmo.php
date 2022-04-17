<?php

namespace Its123Miguel321\MMO\commands;

use Its123Miguel321\MMO\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TF;

class SeeMmo extends Command implements PluginOwned
{
    /** @var Main $main */
    public $main;

    

    /**
     * SeeMmo command constructor
     * 
     * @param Main $main
     * 
     */
    public function __construct(Main $main)
    {
        $this->main = $main;

        parent::__construct('seemmo');
        $this->setDescription('See your own or another player\'s mmo stats');
        $this->setUsage(TF::BOLD . TF::RED . 'Usage: ' . TF::RESET . '/seemmo [player: target]');
    }



    /**
     * Gets the main file
     * 
     * @return Main
     * 
     */
    public function getOwningPlugin() : Main
    {
        return $this->main;
    }



    /**
     * Executes the command
     * 
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * 
     * @return bool
     * 
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if(isset($args[0]))
        {
            $player = $args[0];
        }else{
            $player = $sender->getName();
        }

        $stats = $this->getOwningPlugin()->getManager()->getStats($player);

        if($stats === null)
        {
            $sender->sendMessage(TF::BOLD . TF::RED . '(!) ' . TF::RESET . TF::DARK_GRAY . $player . TF::GRAY . ' does not have any stats!');
            return false;
        }

        $message = '';
        $message .= TF::RESET . TF::WHITE . str_repeat('=', 25) . "\n";
        $message .= TF::BOLD . TF::GOLD . $player . '\'s MMO Stats' . TF::RESET . "\n";
        $message .= TF::DARK_GRAY . 'Combat Level: ' . TF::GRAY . $stats->getLevel('combat') . "\n";
        $message .= TF::DARK_GRAY . 'Combat Progress: ' . TF::GRAY . $stats->getProgress('combat') . '/' . $this->getOwningPlugin()->getApi()->getMaxProgress($player, 'combat') . "\n";
        $message .= TF::DARK_GRAY . 'Mining Level: ' . TF::GRAY . $stats->getLevel('mining') . "\n";
        $message .= TF::DARK_GRAY . 'Mining Progress: ' . TF::GRAY . $stats->getProgress('mining') . '/' . $this->getOwningPlugin()->getApi()->getMaxProgress($player, 'mining')  . "\n";
        $message .= TF::DARK_GRAY . 'Crafting Level: ' . TF::GRAY . $stats->getLevel('crafting') . "\n";
        $message .= TF::DARK_GRAY . 'Crafting Progress: ' . TF::GRAY . $stats->getProgress('crafting') . '/' . $this->getOwningPlugin()->getApi()->getMaxProgress($player, 'crafting')  . "\n";
        $message .= TF::DARK_GRAY . 'Tree Cutting Level: ' . TF::GRAY . $stats->getLevel('treecutting') . "\n";
        $message .= TF::DARK_GRAY . 'Tree Cutting Progress: ' . TF::GRAY . $stats->getProgress('treecutting') . '/' . $this->getOwningPlugin()->getApi()->getMaxProgress($player, 'treecutting')  . "\n";
        $message .= TF::DARK_GRAY . 'Building Level: ' . TF::GRAY . $stats->getLevel('building') . "\n";
        $message .= TF::DARK_GRAY . 'Building Progress: ' . TF::GRAY . $stats->getProgress('building') . '/' . $this->getOwningPlugin()->getApi()->getMaxProgress($player, 'building')  . "\n";
        $message .= TF::RESET . TF::WHITE . str_repeat('=', 25);

        $sender->sendMessage($message);
        return true;
    }
}