<?php

namespace DerCooleVonDem\EconomyLite\cmd\sub;

use DerCooleVonDem\EconomyLite\config\LanguageProvider;
use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\command\CommandSender;

class DeleteSubCommand extends EconomyLiteSubCommand {

    public function __construct()
    {
        parent::__construct("delete", LanguageProvider::getInstance()->tryGet("delete-sub-description"), LanguageProvider::getInstance()->tryGet("delete-sub-usage"), "economylite.sub.delete");
    }

    public function execute(CommandSender $sender, array $args): void
    {
        if(count($args) < 1) {
            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("delete-sub-usage"));
            return;
        }

        EconomyLite::hasAccount($args[0])->onCompletion(function ($exists) use ($args, $sender) {
            if(!$exists) {
                $sender->sendMessage(LanguageProvider::getInstance()->tryGet("delete-sub-no-account"));
                return;
            }

            EconomyLite::getMoney($args[0])->onCompletion(function ($playerMoney) use ($sender, $args) {
                EconomyLite::addEconomyChange($sender->getName(), -$playerMoney);
                EconomyLite::deleteAccount($args[0]);
                $sender->sendMessage(LanguageProvider::getInstance()->tryGet("delete-sub-success", ["{NAME}" => $args[0]]));
            }, fn() => null);
        }, fn() => null);
    }

}