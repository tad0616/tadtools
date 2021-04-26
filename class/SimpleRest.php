<?php

namespace XoopsModules\Tadtools;

use Xmf\Jwt\TokenReader;

class SimpleRest
{

    private $uid = 0;
    private $groups = [];
    private $user = [];
    private $httpVersion = "HTTP/1.1";

    public function __construct($token)
    {
        $this->getXoopsSUser($token);
    }

    public function setHttpHeaders($statusCode)
    {

        $statusMessage = $this->getHttpStatusMessage($statusCode);
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400'); // cache for 1 day
        }

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            }

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }

            exit(0);
        }
        header($this->httpVersion . " " . $statusCode . " " . $statusMessage);
        header("Content-Type: application/json; charset=utf-8");
    }

    public function getHttpStatusMessage($statusCode)
    {
        $httpStatus = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported');
        return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $status[500];
    }

    public function getXoopsSUser($token = '')
    {
        if ($token) {
            $rememberClaims = TokenReader::fromString('rememberme', $token);
            if (false !== $rememberClaims && !empty($rememberClaims->uid)) {
                $this->uid = $rememberClaims->uid;
                $member_handler = xoops_gethandler('member');
                $user = $member_handler->getUser($rememberClaims->uid);
                $this->groups = $user->getGroups();
                $int_arr = ['uid', 'user_viewemail', 'posts', 'attachsig', 'rank', 'level', 'last_login', 'uorder', 'notify_method', 'notify_mode', 'user_mailok'];
                foreach ($user->vars as $key => $v) {
                    if (in_array($key, $int_arr)) {
                        $this->user_vars[$key] = (int) $v['value'];
                    } else {
                        $this->user_vars[$key] = $v['value'];
                    }
                }
            }
            return $data = ['uid' => (int) $this->uid, 'groups' => $this->groups, 'user' => $this->user_vars];
        }
    }

    public function getUid($token = '')
    {
        return $this->uid;
    }

    public function getGroups($token = '')
    {
        return $this->groups;
    }

    public function getUser($token = '')
    {
        return $this->user_vars;
    }

    public function isAdmin($module_name = '')
    {
        $modhandler = xoops_gethandler('module');
        $xoopsModule = $modhandler->getByDirname($module_name);
        $module_id = $xoopsModule->mid();
        $moduleperm_handler = xoops_getHandler('groupperm');

        return $moduleperm_handler->checkRight('module_admin', $module_id, $this->getGroups());

    }

}
