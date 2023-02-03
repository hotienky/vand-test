<?php

namespace App\Pipelines;

use Illuminate\Pipeline\Pipeline;
use Throwable;

abstract class AbstractFilterPipeline extends Pipeline
{
    /**
     * Get a Closure that represents a slice of the application onion.
     *
     * @return \Closure
     */
    protected function carry()
    {
        $context = $this->context;
        return function ($stack, $pipe) use ($context){
            return function ($passable) use ($stack, $pipe, $context) {
                try {
                    if (is_callable($pipe)) {
                        // If the pipe is a callable, then we will call it directly, but otherwise we
                        // will resolve the pipes out of the dependency container and call it with
                        // the appropriate method and arguments, returning the results back out.
                        return $pipe($passable, collect($context ?? array()), $stack);
                    } elseif (!is_object($pipe)) {
                        [$name, $parameters] = $this->parsePipeString($pipe);

                        // If the pipe is a string we will parse the string and resolve the class out
                        // of the dependency injection container. We can then build a callable and
                        // execute the pipe function giving in the parameters that are required.
                        $pipe = $this->getContainer()->make($name);

                        $parameters = array_merge([$passable, collect($context ?? array()), $stack], $parameters);
                    } else {
                        // If the pipe is already an object we'll just make a callable and pass it to
                        // the pipe as-is. There is no need to do any extra parsing and formatting
                        // since the object we're given was already a fully instantiated object.
                        $parameters = [$passable, collect($context ?? array()), $stack];
                    }

                    $carry = method_exists($pipe, $this->method)
                        ? $pipe->{$this->method}(...$parameters)
                        : $pipe(...$parameters);

                    return $this->handleCarry($carry);
                } catch (Throwable $e) {
                    return $this->handleException($passable, $e);
                }
            };
        };
    }
    protected $context;
    protected function with(array $context): AbstractFilterPipeline
    {
        $this->context = $context;
        return $this;
    }
}
