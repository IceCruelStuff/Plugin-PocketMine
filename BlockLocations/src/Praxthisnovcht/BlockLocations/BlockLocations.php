<?php

namespace Praxthisnovcht\BlockLocations;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\level\Position;
use pocketmine\math\Vector2;
use pocketmine\math\Vector3;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\block\BlockBreakEvent;


class BlockLocations extends PluginBase implements Listener
{

    public $locations = array();

    public function onEnable(): void
    {    
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
    }

    public function onDisable(): void
    {

    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if (strtolower($command->getName()) == "blockl") {
            $brek = $sender->getID();
            $pos = $sender->getName();

            if (! (in_array($brek, $this->locations))) {
                $this->locations[$pos] = $brek;
                $sender->sendMessage("§e[BlockLocations] Locations is §aAvailable.\n§eBreak the blocks or want to know the position ");
            } else {
                $fr = array_search($brek, $this->locations);
                unset($this->locations[$fr]);
                $sender->sendMessage("§e[BlockLocations] Locations is §cDisabled.\n§9Thank you for using!");
            }
        }
    }

    public function onBlockBeak(BlockBreakEvent $event)
    {
        $log = $event->getPlayer()->getID();
        
        if (in_array($log, $this->locations)) {
            $ru = $event->getBlock();
            $zoo = strtolower($event->getPlayer()->getName());
            $this->pos[$zoo] = new Vector3(
                $ru->getX(),
                $ru->getY(),
                $ru->getZ()
            );
            $event->getPlayer()->sendMessage(
                "§e<Position> :\n§9x->" .
                $this->pos[$zoo]->getX() .
                "\n§9y->" .
                $this->pos[$zoo]->getY() .
                "\n§9z->" .
                $this->pos[$zoo]->getZ() .
                "§9"
            );
            $event->getPlayer()->sendTip("§eCoordinated created!"); 
            $event->setCancelled(true);
        }
    }

}
