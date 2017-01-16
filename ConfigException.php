<?php
    /**
     * Created by PhpStorm.
     * User: pavel
     * Date: 14.01.2017
     * Time: 20:01
     */

    namespace common\components\Slack;

    use Exception;

    class ConfigException extends \Exception
    {
        public function __construct($message = "", $code = 0, Exception $previous = null)
        {
            $message = 'Your config must be contain';

            parent::__construct($message, $code, $previous);
        }

    }

    /*class TokenException extends \Exception
    {
        public function __construct($message = "", $code = 0, Exception $previous = null)
        {
            $message = 'Tokens do not match';
            parent::__construct($message, $code, $previous);
        }

    }*/