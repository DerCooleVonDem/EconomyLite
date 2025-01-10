<?php

namespace DerCooleVonDem\EconomyLite\cmd;

use DerCooleVonDem\EconomyLite\config\LanguageProvider;
use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwnedTrait;

class PurseCommand extends Command {

    use PluginOwnedTrait;

    public function __construct()
    {
        parent::__construct("purse", LanguageProvider::getInstance()->tryGet("purse-cmd-description"), LanguageProvider::getInstance()->tryGet("purse-cmd-usage"));
        $this->setPermission("economylite.cmd.purse");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!EconomyLite::hasAccount($sender->getName())) {
            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("purse-cmd-no-account"));
            return;
        }

        $sender->sendMessage(LanguageProvider::getInstance()->tryGet("purse-cmd-success", ["{MONEY}" => EconomyLite::getMoney($sender->getName())]));

        $paymentHistory = EconomyLite::getPaymentHistory($sender->getName());
        // only the first 5 payments
        $paymentHistory = array_slice($paymentHistory, 0, 5);
        if(count($paymentHistory) === 0) {
            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("purse-cmd-no-history"));
            return;
        }

        $sender->sendMessage(LanguageProvider::getInstance()->tryGet("purse-cmd-history-header"));
        foreach($paymentHistory as $payment) {
            if($payment["sender"] === $sender->getName()) {
                $sender->sendMessage(LanguageProvider::getInstance()->tryGet("purse-cmd-history-item-sent", ["{SENDER}" => "You", "{RECEIVER}" => $payment["receiver"], "{MONEY}" => $payment["money"], "{DATE}" => $payment["date"]]));
            } else {
                $sender->sendMessage(LanguageProvider::getInstance()->tryGet("purse-cmd-history-item-received", ["{SENDER}" => $payment["sender"], "{RECEIVER}" => "You", "{MONEY}" => $payment["money"], "{DATE}" => $payment["date"]]));
            }
        }
    }
}