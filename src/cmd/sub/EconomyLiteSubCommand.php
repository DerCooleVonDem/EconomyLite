<?php

namespace DerCooleVonDem\EconomyLite\cmd\sub;

use pocketmine\command\CommandSender;

abstract class EconomyLiteSubCommand {

    public string $name;
    public string $description;
    public string $usage;
    public string $permission;


    public function __construct(string $name, string $description, string $usage, string $permission) {
        $this->name = $name;
        $this->description = $description;
        $this->usage = $usage;
        $this->permission = $permission;
    }

    public abstract function execute(CommandSender $sender, array $args) : void;
}