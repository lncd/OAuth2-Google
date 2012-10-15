<?php
/**
 * Google OAuth2 Provider
 *
 * This IDP is based on code originally by Phil Sturgeon which can be found here:
 *
 *     https://github.com/philsturgeon/codeigniter-oauth2/blob/master/libraries/Provider/Google.php
 *
 * @package    lncd/oauth2-google
 * @category   Provider
 * @author     Alex Bilbie
 * @copyright  (c) 2012 University of Lincoln
 * @license    http://opensource.org/licenses/mit-license.php
 */
namespace GoogleIDP;

class Google extends \Oauth2\Client\IDP {

    public $scope = array(
        'https://www.googleapis.com/auth/userinfo.profile',
        'https://www.googleapis.com/auth/userinfo.email'
    );

    public $scopeSeperator = ' ';

    public function urlAuthorize()
    {
        return 'https://accounts.google.com/o/oauth2/auth';
    }

    public function urlAccessToken()
    {
        return 'https://accounts.google.com/o/oauth2/token';
    }

    public function urlUserDetails(\Oauth2\Client\Token\Access $token)
    {
        return 'https://www.googleapis.com/oauth2/v1/userinfo?alt=json&'.http_build_query(array(
            'access_token' => (string) $token,
        ));
    }

    public function userDetails($response, \Oauth2\Client\Token\Access $token)
    {
        return array(
            'uid' => $response->id,
            'nickname' => $response->name,
            'name' => $response->name,
            'first_name' => $response->given_name,
            'last_name' => $response->family_name,
            'email' => $response->email,
            'location' => null,
            'image' => (isset($response->picture)) ? $response->picture : null,
            'description' => null,
            'urls' => array(),
        );
    }
}