<?php

  namespace Nicks;

  use pocketmine\plugin\PluginBase;
  use pocketmine\event\Listener;
  use pocketmine\event\player\PlayerQuitEvent;
  use pocketmine\command\Command;
  use pocketmine\command\CommandSender;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\Player;

  class Main extends PluginBase implements Listener {

    public function onEnable() {

      $this->getServer()->getPluginManager()->registerEvents($this, $this);

      $this->getServer()->getLogger()->info("[Nicks] Enabled.");

    }

    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {

      $this->nicks = array();

      if(strtolower($cmd->getName()) === "nick") {

        if(!(isset($args[0]))) {

          $sender->sendMessage(TF::RED . "Error: not enough args. Usage: /nick <nick | off>");

          return true;

        } else {

          if(!($args[0] === "off")) {

            $nick = implode(" ", $args);

            $this->nicks[$nick] = $sender->getName();

            $sender->setDisplayName($nick);

            $sender->setNameTag($name);

            $sender->sendMessage(TF::GREEN . "Your Nick Was Successfully Set.");

            return true;

          } else {

            if(!(isset($this->nicks[$sender->getName()]))) {

              $sender->sendMessage(TF::RED . "You Do Not Have A Nick Set.");

              return true;

            } else {

              $player_real_name = $this->nicks[$sender->getName()];

              $sender->setDisplayName($player_real_name);

              $sender->setNameTag($player_real_name);

              $sender->sendMessage(TF::GREEN . "Reset Your Nick Successfully.");

              return true;

            }

          }

        }

      }

    }

    public function onQuit(PlayerQuitEvent $event) {

      if(isset($this->nicks[$event->getPlayer()->getName()])) {

        $player_real_name = $this->nicks[$event->getPlayer()->getName()];

        $event->getPlayer()->setDisplayName($player_real_name);

        $event->getPlayer()->setNameTag($player_real_name);

        unset($this->nicks[$event->getPlayer()->getName()]);

      }

    }

  }

?>
