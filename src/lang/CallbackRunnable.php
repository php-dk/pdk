<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 24.09.17
 * Time: 0:06
 */

namespace phpdk\lang;


class CallbackRunnable implements RunnableInterface
{
    /** @var  callable */
    protected $callback;

    /**
     * CallbackRunnable constructor.
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function run(): void
    {
        call_user_func($this->callback);
    }
}