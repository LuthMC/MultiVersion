<?php

namespace Luthfi\MultiVersion;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\network\mcpe\protocol\ProtocolInfo;

class MultiVersionPlugin extends PluginBase implements Listener {

    private $supportedProtocols = [
        ProtocolInfo::CURRENT_PROTOCOL,
        448,
        450,
        451
    ];

    public function onEnable(): void {
        $this->getLogger()->info("MultiVersionPlugin enabled!");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onDisable(): void {
        $this->getLogger()->info("MultiVersionPlugin disabled!");
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $protocol = $player->getNetworkSession()->getProtocolVersion();

        if (!in_array($protocol, $this->supportedProtocols)) {
            $player->kick("Your version is not supported! Supported versions: 1.20.60 to 1.20.80");
        }
    }
}
