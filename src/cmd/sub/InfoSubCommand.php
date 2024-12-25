<?php

namespace DerCooleVonDem\EconomyLite\cmd\sub;

use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\command\CommandSender;

class InfoSubCommand extends EconomyLiteSubCommand {

    public function __construct()
    {
        parent::__construct("info", "Get information about the economy", "/economylite info", "economylite.sub.info");
    }

    public function execute(CommandSender $sender, array $args): void
    {
        $sender->sendMessage("Money in exchange: " . EconomyLite::getAllMoney());

        // economy changes
        $changes = EconomyLite::getEconomyChanges();
        // keys = player, money, date
        $sender->sendMessage("\nRecent economy changes:");
        foreach($changes as $change) {
            $positiveChange = $change["money"] > 0;
            $sender->sendMessage("[" . $change["date"] . "] " . $change["player"] . " " . ($positiveChange ? "added" : "removed") . " " . abs($change["money"]));
        }
    }
}