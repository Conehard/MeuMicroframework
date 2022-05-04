<?php

namespace MeuMicroframework\DependencyInjection;

use MeuMicroframework\DependencyInjection\Exceptions\NotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private $services = [];

    public function register($key, $value)
    {
        $this->services[$key] = $this->resolveDependency($value);
        return $this;
    }

    public function get($id)
    {
        try {
            if (isset($this->services[$id])) {
                return $this->services[$id];
            } else {
                $this->services[$id] = $this->resolveDependency($id);
                return $this->services[$id];
            }

        } catch (\ReflectionException $ex) {
            throw new NotFoundException($ex->getMessage());
        } catch (\Exception $ex) {
            throw new NotFoundException($ex->getMessage());
        }
    }

    public function has($id): bool
    {
        return isset($this->services[$id]);
    }

    public function getServices()
    {
        return $this->services;
    }

    private function resolveDependency($item)
    {
        if (is_callable($item)) {
            return $item();
        }

        $reflectionItem = new \ReflectionClass($item);
        return $this->getInstance($reflectionItem);
    }

    private function getInstance(\ReflectionClass $item)
    {
        $constructor = $item->getConstructor();

        if (is_null($constructor) || $constructor->getNumberOfRequiredParameters() == 0) {
            return $item->newInstance();
        }

        $params = [];
        foreach ($constructor->getParameters() as $param) {
            $params[] = $this->get($param->getType()->getName());
        }
        return $item->newInstanceArgs($params);
    }
}
