<?php

namespace Orio\Query\Commands;

use Orio\Query\Parameters\IParameter;

/**
 * Class AbstractCommand
 * @package Orio\Query\Commands
 *
 * @property [Orio\Query\ModifiersIModifier] $modifiers
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
    public function addParameter(IParameter $parameter)
    {
        $this->parameters[] = $parameter;
        return $this;
    }

    /**
     * @return IParameter[]
     */
    public function getParameters()
    {
        return (array)$this->parameters;
    }

    /**
     * @return IParameter[]
     */
    public function getRequiredParameters()
    {
        $found = [];
        foreach ($this->requiredParameters() as $requiredParameter) {
            foreach ($this->parameters as $parameter) {
                if ($parameter instanceof $requiredParameter) {
                    $found[] = $parameter;
                }
            }
        }
        return $found;
    }

    public function build()
    {
        $sql = $this->getAlias();

        $requiredParams = $this->getRequiredParameters();
        foreach ($requiredParams as $requiredParam) {
            $sql .= " {$requiredParam->build()}";
        }

        return $sql;
    }
}