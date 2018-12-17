<?php

namespace Orio\Query\Commands;

use Orio\Query\Parameters\IParameter;

/**
 * Class AbstractCommand
 * @package Orio\Query\Commands
 *
 * @property IParameter[] $parameters
 */
abstract class AbstractCommand implements ICommand
{
    private $parameters = [];

    public function getAlias()
    {
        try {
            return strtoupper((new \ReflectionClass($this))->getShortName());
        } catch (\ReflectionException $exception) {
            return false;
        }
    }

    /**
     * @param IParameter $parameter
     * @return $this
     */
    public function pushParameter(IParameter $parameter)
    {
        $this->parameters[] = $parameter;
        return $this;
    }

    /**
     * @param string|IParameter $parameter
     * @return IParameter|false
     */
    public function popParameter($parameter = null)
    {
        if (!$parameter) {
            return array_pop($this->parameters);
        } else {
            foreach ($this->parameters as $key => $myParameter) {
                if ($myParameter instanceof $parameter) {
                    unset($this->parameters[$key]);
                    return $myParameter;
                }
            }
        }
        return false;
    }

    /**
     * @param IParameter $parameter
     * @return bool
     */
    public static function isRequired(IParameter $parameter) {
        return in_array(get_class($parameter), static::requiredParameters());
    }

    /**
     * @return IParameter[]
     */
    public function getParameters()
    {
        return (array)$this->parameters;
    }

    public function build()
    {
        $sql = $this->getAlias();

        foreach ($this::parametersOrder() as $parameterClass) {
            while ($parameter = $this->popParameter($parameterClass)) {
                $sql .= " {$parameter->build()}";
            }
        }

        return $sql;
    }


}