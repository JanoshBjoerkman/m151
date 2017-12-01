<?php
namespace M151;

class SessionHandler
{
    private static $handler;

    private function __construct()
    {
        // always use session cookie. $_GET['PHPSESSID'] is invalid 
        // -> see: http://packetcode.com/article/preventing-session-hijacking-in-php
        ini_set( 'session.use_only_cookies', TRUE );				
        ini_set( 'session.use_trans_sid', FALSE );
        // send cookies only with HTTPS
        // -> see: https://stackoverflow.com/questions/25047170/php-session-cookie-secure-disables-sessions-when-set-to-true
        ini_set( 'session.cookie_secure', TRUE );
    }

    public static function getHandler()
    {
        if(!static::$handler)
        {
            static::$handler = new SessionHandler();
        }
        return static::$handler;
    }

    public function refresh()
    {
        session_start();
        session_regenerate_id(true);
    }

    public function login($accountID)
    {
        $this->refresh();
        $_SESSION['Account_ID'] = $accountID;
    }

    public function logout()
    {
        $this->refresh();
        session_unset();
        session_destroy();
    }
}