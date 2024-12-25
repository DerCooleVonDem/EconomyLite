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
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;

class EconomyLiteCommand extends Command {

    public array $subCommands = [];

    public function __construct()
    {
        parent::__construct("economylite", "Use economylite", "/economylite <sub> <args>", ["el", "eco"]);
        $this->setPermission("economylite.command");
        $this->addSubcommand(new HelpSubCommand());
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

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(count($args) < 1) {
            $sender->sendMessage("Usage: /economylite <sub> <args>");
            return;
        }

        $subCommand = $this->subCommands[$args[0]] ?? null;

        if($subCommand === null) {
            $sender->sendMessage("Subcommand not found");
            return;
        }

        // perm check
        if(!$sender->hasPermission($subCommand->permission)) {
            $sender->sendMessage("You don't have permission to use this command");
            return;
        }

        $subCommand->execute($sender, array_slice($args, 1));
    }
}