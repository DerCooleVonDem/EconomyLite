<?php

namespace DerCooleVonDem\EconomyLite\cmd\sub;

use DerCooleVonDem\EconomyLite\cmd\EconomyLiteCommand;
use pocketmine\command\CommandSender;

class HelpSubCommand extends EconomyLiteSubCommand {

    private EconomyLiteCommand $cmd;

    public function __construct(EconomyLiteCommand $cmd)
    {
        parent::__construct("help", "Help about the economylite commands", "/economylite help", "economylite.sub.help");
        $this->cmd = $cmd;
    }

    public function execute(CommandSender $sender, array $args): void
    {
        $subCommands = $this->cmd->getSubCommands();
        $sender->sendMessage("EconomyLite admin commands:");
        foreach($subCommands as $subCommand) {
            $sender->sendMessage("/economylite " . $subCommand->name . " - " . $subCommand->description . " - " . $subCommand->usage);
        }
    }
}