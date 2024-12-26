<?php

namespace DerCooleVonDem\EconomyLite\cmd;

use DerCooleVonDem\EconomyLite\cmd\sub\AddSubCommand;
use DerCooleVonDem\EconomyLite\cmd\sub\DeleteSubCommand;
use DerCooleVonDem\EconomyLite\cmd\sub\EconomyLiteSubCommand;
use DerCooleVonDem\EconomyLite\cmd\sub\HelpSubCommand;
use DerCooleVonDem\EconomyLite\cmd\sub\HistorySubCommand;
use DerCooleVonDem\EconomyLite\cmd\sub\InfoSubCommand;
use DerCooleVonDem\EconomyLite\cmd\sub\RemoveSubCommand;
use DerCooleVonDem\EconomyLite\cmd\sub\ShowSubCommand;
use DerCooleVonDem\EconomyLite\config\LanguageProvider;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class EconomyLiteCommand extends Command {

    public array $subCommands = [];

    public function __construct()
    {
        parent::__construct("economylite", LanguageProvider::getInstance()->tryGet("economylite-cmd-description"), LanguageProvider::getInstance()->tryGet("economylite-cmd-usage"), ["el", "eco"]);
        $this->setPermission("economylite.command");
        $this->addSubcommand(new HelpSubCommand($this));
        $this->addSubcommand(new AddSubCommand());
        $this->addSubcommand(new RemoveSubCommand());
        $this->addSubcommand(new InfoSubCommand());
        $this->addSubcommand(new ShowSubCommand());
        $this->addSubcommand(new DeleteSubCommand());
        $this->addSubcommand(new HistorySubCommand());
    }

    public function addSubcommand(EconomyLiteSubCommand $subCommand) : void {
        $this->subCommands[$subCommand->name] = $subCommand;
    }

    public function getSubcommands() : array {
        return $this->subCommands;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(count($args) < 1) {
            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("economylite-cmd-usage"));
            return;
        }

        $subCommand = $this->subCommands[$args[0]] ?? null;

        if($subCommand === null) {
            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("economylite-cmd-no-subcommand"));
            return;
        }

        // perm check
        if(!$sender->hasPermission($subCommand->permission)) {
            $sender->sendMessage(LanguageProvider::getInstance()->tryGet("economylite-cmd-no-permission"));
            return;
        }

        $subCommand->execute($sender, array_slice($args, 1));
    }
}