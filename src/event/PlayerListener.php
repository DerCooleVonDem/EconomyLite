<?php

namespace DerCooleVonDem\EconomyLite\event;

use DerCooleVonDem\EconomyLite\EconomyLite;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class PlayerListener implements Listener {

    public function onJoin(PlayerJoinEvent $event): void {
        EconomyLite::hasAccount($event->getPlayer()->getName())->onCompletion(function ($exists) use ($event) {
            if(!$exists) EconomyLite::createAccount($event->getPlayer()->getName());
        }, fn() => null);
    }

}