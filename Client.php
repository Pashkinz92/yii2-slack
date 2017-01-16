<?php
    /**
     * Created by PhpStorm.
     * User: PAVLO
     * Date: 13.01.2017
     * Time: 14:22
     */

    namespace common\components\Slack;


    use yii\base\Component;

    class Client extends Component
    {
        public $client_id = false;
        public $client_secret = false;
        public $verification_token = false;
        public $webhook_url = false;

        private $_oauth_client = false;
        public $config_file_path = false;

        public function init()
        {
            if(!$this->client_id || !$this->client_secret || !$this->config_file_path )
            {
                throw new ConfigException();
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

        /**
         * @return OAuth
         */
        function getOAuthClient()
        {
            if(!$this->_oauth_client)
            {
                $this->_oauth_client = new OAuth($this->client_id, $this->client_secret, $this->config_file_path);
            }

            return $this->_oauth_client;
        }

    }