<?php

namespace common\components\mail;

/**
 * Class macros
 * @package common\components\mail
 */
class macros
{
    const AFTER_LOAD = 0;

    const BEFORE_REPLACE = 1;

    const AFTER_REPLACE = 2;

    protected $content;

    protected $_values = [];

    protected $_callBeck = [];

    /**
     * @return string
     */
    public function replace()
    {
        $this->eventRun(self::BEFORE_REPLACE);

        foreach ($this->_values as $key => $value) {
            $this->content = str_replace('{' . $key . '}', $value, $this->content);
        }

        $this->eventRun(self::AFTER_REPLACE);

        return $this->content;
    }


    /**
     * @param $content
     * @return string
     */
    public function load($content)
    {
        $this->content = $content;

        $this->eventRun(self::AFTER_LOAD);

        return $this;
    }

    /**
     * @return $this
     */
    public function clear()
    {
        $this->_values = [];

        return $this;
    }


    # event

    /**
     * @param $type
     * @param callable $callBeck
     */
    public function registerEvent($type, callable $callBeck)
    {
        $this->_callBeck[$type][] = $callBeck;
    }

    /**
     * @param $type
     */
    protected function eventRun($type)
    {
        if (array_key_exists($type, $this->_callBeck)) {

            foreach ($this->_callBeck[$type] as $item) {

                $result = $item($this->content);

                if (isset($result)) {
                    $this->content = $result;
                }

            }

        }
    }

    # base

    /**
     * @param $key
     * @param $value
     */
    public function add($key, $value)
    {
        $this->_values[$key] = trim($value);
    }

    /**
     * @param $key
     * @return array
     */
    public function get($key)
    {
        return $this->_values[$key];
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->_values);
    }

    /**
     * @param $key
     */
    public function remove($key)
    {
        unset($this->_values[$key]);
    }


    # magic method

    /**
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return array_key_exists($key, $this->_values);
    }

    /**
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $this->_values[$key] = $value;
    }

    /**
     * @param $key
     * @return array
     */
    public function __get($key)
    {
        return $this->_values[$key];
    }
}