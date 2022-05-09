<?php

namespace BetterInfo\DaDevGuy;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use BetterInfo\DaDevGuy\Commands\MyInfoCommand;
use pocketmine\player\Player;
use Vecnavium\FormsUI\SimpleForm;

class Main extends PluginBase implements Listener{
    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
    
        if($this->getConfig()->get("config-ver") !== 1){
            $this->getLogger()->info("BetterInfo Config Is Not Updated, Please Delete The BetterInfo Folder In plugin_data And Restart The Server!");
        }
    }

    public function infoform($player){
        $form = new SimpleForm(function (Player $player, int $data = null){
            $result = $data;
            if($result === null){
                return true;
            }
        });
        $name = $player->getName();
        $health = $player->getHealth();
        $maxhealth = $player->getHealth()->getMaxHealth();
        $line = "\n";
        $info = str_replace("{health}", "{name}", "{maxhealth}", "{line}", [$health, $name, $maxhealth, $line], $this->getConfig()->get("ui.content"));
        $form->setTitle($this->getConfig()->get("ui.title"));
        $form->setContent($info);
        $player->sendForm($form);
        return $form;
    }
}