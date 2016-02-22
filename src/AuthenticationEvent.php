<?php
namespace T4web\Authentication;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\EventManager\Event;

/**
 * Class AuthenticationEvent
 */
class AuthenticationEvent extends Event
{
    /**
     * Events triggered by eventmanager
     */
    const EVENT_AUTH = 'auth';

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @var Result
     */
    protected $result;

    /**
     * Constructor
     *
     * Accept a target and its parameters.
     *
     * @param  string $name Event name
     * @param  string|object $target
     * @param  array|ArrayAccess $params
     */
    public function __construct($name = null, $target = null, $params = null)
    {
        parent::__construct(self::EVENT_AUTH, $target, $params);
    }

    /**
     * @param AdapterInterface $adapter
     * @return $this
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param Result $result
     * @return $this
     */
    public function setResult(Result $result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return Result
     */
    public function getResult()
    {
        return $this->result;
    }
}
