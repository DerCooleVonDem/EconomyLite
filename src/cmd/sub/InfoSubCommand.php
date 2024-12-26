<?php

namespace DerCooleVonDem\EconomyLite\cmd\sub;

use DerCooleVonDem\EconomyLite\config\LanguageProvider;
use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\command\CommandSender;

class InfoSubCommand extends EconomyLiteSubCommand {

    public function __construct()
    {
        parent::__construct("info", LanguageProvider::getInstance()->tryGet("info-sub-description"), LanguageProvider::getInstance()->tryGet("info-sub-usage"), "economylite.sub.info");
    }

    public function execute(CommandSender $sender, array $args): void
    {
        $sender->sendMessage(LanguageProvider::getInstance()->tryGet("info-sub-money-in-exchange", ["{MONEY}" => EconomyLite::getAllMoney()]));

        // economy changes
        $changes = EconomyLite::getEconomyChanges();
        // keys = player, money, date
        $sender->sendMessage(LanguageProvider::getInstance()->tryGet("info-sub-subheader"));
        foreach($changes as $change) {
            $positiveChange = $change["money"] > 0;
            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("info-sub-change-item", ["{PLAYER}" => $change["player"], "{MONEY}" => $change["money"], "{DATE}" => $change["date"], "{ACTION}" => $positiveChange ? "added" : "removed"]));
        }
    }
}