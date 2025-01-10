<?php

namespace DerCooleVonDem\EconomyLite\cmd\sub;

use DerCooleVonDem\EconomyLite\config\LanguageProvider;
use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\command\CommandSender;

class HistorySubCommand extends EconomyLiteSubCommand {

    public function __construct()
    {
        parent::__construct("history", LanguageProvider::getInstance()->tryGet("history-sub-description"), LanguageProvider::getInstance()->tryGet("history-sub-usage"), "economylite.sub.history");
    }

    public function execute(CommandSender $sender, array $args): void
    {
        if(count($args) < 1) {
            $sender->sendMessage($this->usage);
            return;
        }

        $player = $args[0];
        $limit = $args[1] ?? "100";

        EconomyLite::hasAccount($player)->onCompletion(function ($exists) use ($player, $sender, $limit) {
            if($exists) {
                EconomyLite::getPaymentHistory($player)->onCompletion(function ($history) use ($sender, $player, $limit) {
                    $sender->sendMessage(LanguageProvider::getInstance()->tryGet("history-sub-header", ["{NAME}" => $player]));


                    if($limit !== null) {
                        $history = array_slice($history, 0, $limit);
                    }

                    foreach($history as $payment) {
                        // keys: receiver, sender, money, date
                        $sender->sendMessage(LanguageProvider::getInstance()->tryGet("history-sub-item", ["{RECEIVER}" => $payment["receiver"], "{SENDER}" => $payment["sender"], "{MONEY}" => $payment["money"], "{DATE}" => $payment["date"]]));
                    }
                }, fn() => null);
            }
        }, fn() => null);
    }
}