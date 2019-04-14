<?php

/**
 * elFinder - file manager for web.
 * Session Wrapper Class.
 *
 * @package elfinder
 * @author Naoki Sawada
 **/
class elFinderSession implements elFinderSessionInterface
{
    protected $started = false;

    protected $keys = [];

    protected $prevVal = null;

    protected $base64encode = false;

    protected $opts = [
        'base64encode' => false,
        'keys' => [
            'default' => 'elFinderCaches',
            'netvolume' => 'elFinderNetVolumes',
        ],
    ];

    public function __construct($opts)
    {
        $this->opts = array_merge($this->opts, $opts);
        $this->base64encode = !empty($this->opts['base64encode']);
        $this->keys = $this->opts['keys'];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function start()
    {
        if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
            if (PHP_SESSION_ACTIVE !== session_status()) {
                session_start();
            }
        } else {
            set_error_handler([$this, 'session_start_error'], E_NOTICE);
            session_start();
            restore_error_handler();
        }
        $this->started = session_id() ? true : false;

        if ($this->started && null === $this->prevVal) {
            $this->prevVal = $_SESSION;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        if ($this->started && $this->prevVal !== $_SESSION) {
            session_write_close();
            $this->prevVal = $_SESSION;
        }
        $this->started = false;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $empty = null)
    {
        $closed = false;
        if (!$this->started) {
            $closed = true;
            $this->start();
        }

        $data = null;

        if ($this->started) {
            $session = &$this->getSessionRef($key);
            $data = $session;
            if ($data && $this->base64encode) {
                $data = $this->decodeData($data);
            }
        }

        $checkFn = null;
        if (null !== $empty) {
            if (is_string($empty)) {
                $checkFn = 'is_string';
            } elseif (is_array($empty)) {
                $checkFn = 'is_array';
            } elseif (is_object($empty)) {
                $checkFn = 'is_object';
            } elseif (is_float($empty)) {
                $checkFn = 'is_float';
            } elseif (is_int($empty)) {
                $checkFn = 'is_int';
            }
        }

        if (null === $data || ($checkFn && !$checkFn($data))) {
            $session = $data = $empty;
        }

        if ($closed) {
            $this->close();
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $data)
    {
        $closed = false;
        if (!$this->started) {
            $closed = true;
            $this->start();
        }
        $session = &$this->getSessionRef($key);
        if ($this->base64encode) {
            $data = $this->encodeData($data);
        }
        $session = $data;

        if ($closed) {
            $this->close();
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        $closed = false;
        if (!$this->started) {
            $closed = true;
            $this->start();
        }

        list($cat, $name) = array_pad(explode('.', $key, 2), 2, null);
        if (null === $name) {
            if (!isset($this->keys[$cat])) {
                $name = $cat;
                $cat = 'default';
            }
        }
        if (isset($this->keys[$cat])) {
            $cat = $this->keys[$cat];
        } else {
            $name = $cat . '.' . $name;
            $cat = $this->keys['default'];
        }
        if (null === $name) {
            unset($_SESSION[$cat]);
        } else {
            if (isset($_SESSION[$cat]) && is_array($_SESSION[$cat])) {
                unset($_SESSION[$cat][$name]);
            }
        }

        if ($closed) {
            $this->close();
        }

        return $this;
    }

    protected function &getSessionRef($key)
    {
        $session = null;
        if ($this->started) {
            list($cat, $name) = array_pad(explode('.', $key, 2), 2, null);
            if (null === $name) {
                if (!isset($this->keys[$cat])) {
                    $name = $cat;
                    $cat = 'default';
                }
            }
            if (isset($this->keys[$cat])) {
                $cat = $this->keys[$cat];
            } else {
                $name = $cat . '.' . $name;
                $cat = $this->keys['default'];
            }
            if (null === $name) {
                if (!isset($_SESSION[$cat])) {
                    $_SESSION[$cat] = null;
                }
                $session = &$_SESSION[$cat];
            } else {
                if (!isset($_SESSION[$cat]) || !is_array($_SESSION[$cat])) {
                    $_SESSION[$cat] = [];
                }
                if (!isset($_SESSION[$cat][$name])) {
                    $_SESSION[$cat][$name] = null;
                }
                $session = &$_SESSION[$cat][$name];
            }
        }

        return $session;
    }

    protected function encodeData($data)
    {
        if ($this->base64encode) {
            $data = base64_encode(serialize($data));
        }

        return $data;
    }

    protected function decodeData($data)
    {
        if ($this->base64encode) {
            if (is_string($data)) {
                if (false !== ($data = base64_decode($data, true))) {
                    $data = unserialize($data);
                } else {
                    $data = null;
                }
            } else {
                $data = null;
            }
        }

        return $data;
    }

    protected function session_start_error($errno, $errstr)
    {
    }
}
