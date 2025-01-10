<?php

namespace DerCooleVonDem\EconomyLite\cmd\sub;

use DerCooleVonDem\EconomyLite\config\LanguageProvider;
use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\command\CommandSender;

class ShowSubCommand extends EconomyLiteSubCommand {

    public function __construct()
    {
        parent::__construct("show", LanguageProvider::getInstance()->tryGet("show-sub-description"), LanguageProvider::getInstance()->tryGet("show-sub-usage"), "economylite.sub.show");
    }

    public function execute(CommandSender $sender, array $args): void
    {
        if(count($args) < 1) {
            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("show-sub-usage"));
            return;
        }
        $player = $args[0];

        EconomyLite::hasAccount($player)->onCompletion(function ($exists) use ($player, $sender) {
            if(!$exists) {
                $sender->sendMessage(LanguageProvider::getInstance()->tryGet("show-sub-no-account"));
                return;
            }

            EconomyLite::getMoney($player)->onCompletion(function ($money) use ($sender, $player) {
                $sender->sendMessage(LanguageProvider::getInstance()->tryGet("show-sub-success", ["{NAME}" => $player, "{MONEY}" => $money]));
            }, fn() => null );
        }, fn() => null );
    }
}