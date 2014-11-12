<?php namespace Phonon\Poly;

class HandlerMap
{

    protected $handlers = [];

    public function addHandler($type, $handler)
    {
        $this->handlers[$type] = $handler;
    }

    public function getHandlerByName($type)
    {
        if (!isset($this->handlers[$type])) {
            throw new \InvalidArgumentException("Unknown handler for " . $type);
        }

        return $this->handlers[$type];
    }

    public function getHandler($obj)
    {
        if (!is_object($obj)) {
            return $this->getHandlerByName(gettype($obj));
        }
        $class = get_class($obj);
        $handler = null;
        $ex = null;
        while (true) {
            try {
                $handler = $this->getHandlerByName($class);

                return $handler;
            } catch (\Exception $e) {
                if (!$ex) {
                    $ex = $e;
                }
                $class = get_parent_class($class);
                if (!$class) {
                    break;
                }
            }
        }
        $rObj = new \ReflectionObject($obj);
        $interfaces = $rObj->getInterfaceNames();
        foreach ($interfaces as $interface) {
            try {
                $handler = $this->getHandlerByName($interface);

                return $handler;
            } catch (\Exception $e) {
                continue;
            }
        }
        throw $ex;
    }
}
