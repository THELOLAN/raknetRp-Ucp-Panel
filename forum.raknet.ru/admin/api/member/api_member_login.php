<?php

/**
 * IBResource, LTD; Ritsuka, UnLTD
 * IP.Board 
 * Member authorization API file
 *
 * @author      GiV, Ritsuka 
 * @copyright   (c) 2010 IBResource, LTD.
 * @link        http://www.ibresource.ru
 * @version     1.0.0
 *
 */
if ( ! class_exists( 'apiCore' ) )
{
    require_once( FORUM_PATH . 'admin/api/api_core.php' );
}

class apiMemberLogin extends apiCore
{
    private $_handler = NULL;
    public $path_to_ipb = FORUM_PATH;
    
    public function childInit()
    {
        require_once( IPS_ROOT_PATH . 'sources/base/ipsController.php' );
		require_once( IPS_ROOT_PATH . 'sources/base/ipsMember.php' );
        require_once( IPS_ROOT_PATH . 'sources/handlers/han_login.php' );
        $this->_handler = new han_login( $this->registry );
        $this->_handler->init();        
    }
    
    public function login( $username, $password, $remember = TRUE )
    {
        $this->request['username'] = $username;
        $this->request['password'] = $password;
        $this->request['rememberMe'] = $remember;
        return $this->_handler->verifyLogin();
    }

    public function logout()
    {
        IPSCookie::set( "member_id" , "0"  );
        IPSCookie::set( "pass_hash" , "0"  );
        IPSCookie::set( "anonlogin" , "-1" );
        if( is_array( $_COOKIE ) )
        {
            foreach( $_COOKIE as $cookie => $value)
            {
                if ( stripos( $cookie, $this->settings['cookie_id'] . 'ipbforumpass' ) !== false )
                {
                    IPSCookie::set( $cookie, '-', -1 );
                }
            }
        }
        $this->registry->member()->sessionClass()->convertMemberToGuest();
        return true;
    }

    public function getMember()
    {
		return  $this->registry->member()->fetchMemberData();
    }
}