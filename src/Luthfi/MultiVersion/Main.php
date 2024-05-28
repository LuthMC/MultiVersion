<?php

namespace Luthfi\MultiVersion;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("MultiVersion enabled!");
    }

    public function onDisable(): void {
        $this->getLogger()->info("MultiVersion disabled!");
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $protocolVersion = $player->getNetworkSession()->getProtocolVersion();
        $this->getLogger()->info("Player " . $player->getName() . " joined with protocol version: " . $protocolVersion);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === "mv") {
            if ($sender instanceof Player) {
                if ($sender->hasPermission("multiversion.use")) {
                    $protocolVersion = $sender->getNetworkSession()->getProtocolVersion();
                    $sender->sendMessage(TextFormat::GREEN . "Your protocol version is: " . $protocolVersion);
                    return true;
                } else {
                    $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command.");
                    return true;
                }
            } else {
                $sender->sendMessage(TextFormat::RED . "This command can only be used in-game.");
                return true;
            }
        }
        return false;
    }
}
