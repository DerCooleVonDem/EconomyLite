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

        if(!EconomyLite::hasAccount($player)) {
            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("show-sub-no-account"));
            return;
        }

        $sender->sendMessage(LanguageProvider::getInstance()->tryGet("show-sub-success", ["{NAME}" => $player, "{MONEY}" => EconomyLite::getMoney($player)]));
    }
}