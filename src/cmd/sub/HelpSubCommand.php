<?php

namespace DerCooleVonDem\EconomyLite\cmd\sub;

use DerCooleVonDem\EconomyLite\cmd\EconomyLiteCommand;
use DerCooleVonDem\EconomyLite\config\LanguageProvider;
use pocketmine\command\CommandSender;

class HelpSubCommand extends EconomyLiteSubCommand {

    private EconomyLiteCommand $cmd;

    public function __construct(EconomyLiteCommand $cmd)
    {
        parent::__construct("help", LanguageProvider::getInstance()->tryGet("help-sub-description"), LanguageProvider::getInstance()->tryGet("help-sub-usage"), "economylite.sub.help");
        $this->cmd = $cmd;
    }

    public function execute(CommandSender $sender, array $args): void
    {
        $subCommands = $this->cmd->getSubCommands();
        $sender->sendMessage(LanguageProvider::getInstance()->tryGet("help-sub-header"));
        foreach($subCommands as $subCommand) {
            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("help-sub-item", ["{NAME}" => $subCommand->name, "{DESCRIPTION}" => $subCommand->description, "{USAGE}" => $subCommand->usage]));
        }
    }
}