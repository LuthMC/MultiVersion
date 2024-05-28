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
        554,
        555,
        556,
        557,
        558,
        559,
        560,
        561,
        562,
        563,
        564,
        565,
        566,
        567,
        568,
        569,
        570,
        571,
        572,
        573,
        574,
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
        $protocolVersion = $player->getNetworkSession()->getProtocolVersion();
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
