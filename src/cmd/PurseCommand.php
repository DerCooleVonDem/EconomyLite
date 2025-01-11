<?php

namespace DerCooleVonDem\EconomyLite\cmd;

use DerCooleVonDem\EconomyLite\config\LanguageProvider;
use DerCooleVonDem\EconomyLite\EconomyLite;
use DerCooleVonDem\EconomyLite\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;

class PurseCommand extends Command implements PluginOwned {

    use PluginOwnedTrait;

    public function __construct()
    {
        parent::__construct("purse", LanguageProvider::getInstance()->tryGet("purse-cmd-description"), LanguageProvider::getInstance()->tryGet("purse-cmd-usage"));
        $this->setPermission("economylite.cmd.purse");
        $this->owningPlugin = Main::getInstance();
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        EconomyLite::hasAccount($sender->getName())->onCompletion(function($exists) use ($sender) {
            if(!$exists) {
                $sender->sendMessage(LanguageProvider::getInstance()->tryGet("purse-cmd-no-account"));
                return;
            }

            EconomyLite::getMoney($sender->getName())->onCompletion(function($money) use ($sender) {
                $sender->sendMessage(LanguageProvider::getInstance()->tryGet("purse-cmd-success", ["{MONEY}" => $money]));

                EconomyLite::getPaymentHistory($sender->getName())->onCompletion(function($paymentHistory) use ($sender) {
                    // only the first 5 payments
                    $paymentHistory = array_slice($paymentHistory, 0, 5);
                    if(count($paymentHistory) === 0) {
                        $sender->sendMessage(LanguageProvider::getInstance()->tryGet("purse-cmd-no-history"));
                        return;
                    }

                    $sender->sendMessage(LanguageProvider::getInstance()->tryGet("purse-cmd-history-header"));
                    $isRecent = true;
                    foreach($paymentHistory as $payment) {
                        if($payment["sender"] === $sender->getName()) {
                            $recentSign = $isRecent ? LanguageProvider::getInstance()->tryGet("purse-cmd-history-recent-sign") : "";
                            if($isRecent) {
                                $isRecent = false;
                            }
                            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("purse-cmd-history-item", ["{SENDER}" => "You", "{RECEIVER}" => $payment["receiver"], "{MONEY}" => $payment["money"], "{DATE}" => $payment["date"]]) . $recentSign);
                        } else {
                            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("purse-cmd-history-item", ["{SENDER}" => $payment["sender"], "{RECEIVER}" => "You", "{MONEY}" => $payment["money"], "{DATE}" => $payment["date"]]));
                        }
                    }
                }, fn() => null);
            }, fn() => null);
        }, fn() => null);
    }
}