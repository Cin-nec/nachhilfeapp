<?php

namespace App\Server\MVC;

use App\App\AbstractMVC\AbstractController;
use App\Server\ServerDatabase;

class ServerController extends AbstractController {

    public $guildids = [];
    public $channelids = [];
    public $channel_names = [];

    public function __construct(ServerDatabase $serverDatabase){
        $this->serverDatabase = $serverDatabase;
    }

    public function serverPage(){
        session_start();
        $access_token = $_SESSION["access_token"];
        $header = array("Authorization: Bearer $access_token", "Content-Type: application/x-www-form-urlencoded");
        $discord_guilds_url = "https://discordapp.com/api/users/@me/guilds";
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $discord_guilds_url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_PROXY_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_PROXY_SSL_VERIFYPEER, 0);

        $result_guilds = curl_exec($ch);
        $result_guilds = json_decode($result_guilds, true);
        $_SESSION['userData']['guilds'] = $result_guilds;

        $guild_ids = $this->serverDatabase->getGuildIds();
        foreach ($guild_ids as $item){
            $this->guildids[] = $item->guild_id;
            $this->channelids[] = $item->channel_ids;
            $this->channel_names[] = $item->channel_names;
        }
        $this->pageload("Server", "server", [
            "guildIDs" => $this->guildids,
            "channelIDs" => $this->channelids,
            "channelNames" => $this->channel_names,
        ]);
    }
}