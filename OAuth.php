<?php
    /**
     * Created by PhpStorm.
     * User: PAVLO
     * Date: 13.01.2017
     * Time: 14:22
     */

    namespace common\components\Slack;


    class OAuth
    {
        const CONFIG_FILE_NAME = 'config.json';

        private $client_id = false;
        private $client_secret = false;

        private $config_file = false;
        private $oauth_url = 'https://slack.com/api/oauth.access';

        public function __construct($client_id, $client_secret, $config_file = false) {
            $this->client_id = $client_id;
            $this->client_secret = $client_secret;

            if(!$config_file)
            {
                $this->config_file = dirname(__FILE__) . '/' . self::CONFIG_FILE_NAME;
            }
            else
            {
                $this->config_file = config_file_path . '/' . self::CONFIG_FILE_NAME;

            }
        }

        private function send($url, $params)
        {
            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($result, true);
            if($result['ok'])
            {
                return $result;
            }

            return false;
        }

        function getOAuthButton()
        {
            return '<a href="https://slack.com/oauth/authorize?scope=incoming-webhook,commands,bot&client_id=' . $this->client_id . '"><img alt="Add to Slack" height="40" width="139" src="https://platform.slack-edge.com/img/add_to_slack.png" srcset="https://platform.slack-edge.com/img/add_to_slack.png 1x, https://platform.slack-edge.com/img/add_to_slack@2x.png 2x" /></a>';

            '{"ok":true,"access_token":"","scope":"identify,bot,commands,incoming-webhook","user_id":"U3AKKV6MQ","team_name":"pavlo","team_id":"","incoming_webhook":{"channel":"board-home","channel_id":"","configuration_url":"","url":""},"bot":{"bot_user_id":"U3R5YU9C2","bot_access_token":""}}';
        }


        public function OAuth($code)
        {
            $result = $this->send($this->oauth_url, ['code' => $code, 'client_id' => $this->client_id, 'client_secret' => $this->client_secret]);

            if($result === false)
            {
                return;
            }

            $result['date'] = date('d.m.Y H:i:s');
            file_put_contents($this->config_file, json_encode($result, JSON_PRETTY_PRINT));

            echo "Your config file has been saved to <i>$this->config_file</i>";
        }

    }