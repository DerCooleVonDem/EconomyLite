<?php

namespace DerCooleVonDem\EconomyLite\event;

use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class PlayerListener implements Listener {

    public function onJoin(PlayerJoinEvent $event): void {
        if(!EconomyLite::hasAccount($event->getPlayer()->getName())){
            EconomyLite::createAccount($event->getPlayer()->getName());
        }
    }

}