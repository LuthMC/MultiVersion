<?php

namespace Luthfi\MultiVersion;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener {

    private const SUPPORTED_PROTOCOLS = [
        554, // 1.20.60
        555, // 1.20.61
        556, // 1.20.62
        557, // 1.20.63
        558, // 1.20.64
        559, // 1.20.65
        560, // 1.20.66
        561, // 1.20.67
        562, // 1.20.68
        563, // 1.20.69
        564, // 1.20.70
        565, // 1.20.71
        566, // 1.20.72
        567, // 1.20.73
        568, // 1.20.74
        569, // 1.20.75
        570, // 1.20.76
        571, // 1.20.77
        572, // 1.20.78
        573, // 1.20.79
        574, // 1.20.80
    ];

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("MultiVersion enabled!");
    }

    public function onDisable(): void {
        $this->getLogger()->info("MultiVersion disabled!");
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $protocolVersion = $player->getNetworkSession()->getProtocolId();
        if (in_array($protocolVersion, self::SUPPORTED_PROTOCOLS, true)) {
            $this->getLogger()->info("Player " . $player->getName() . " joined with supported protocol version: " . $protocolVersion);
        } else {
            $this->getLogger()->warning("Player " . $player->getName() . " joined with unsupported protocol version: " . $protocolVersion);
            $player->kick("Your Minecraft version is not supported on this server.");
        }
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === "mv") {
            if ($sender instanceof Player) {
                if ($sender->hasPermission("multiversion.use")) {
                    $protocolVersion = $sender->getNetworkSession()->getProtocolId();
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
