<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 24.09.17
 * Time: 0:03
 */

namespace phpdk\lang;


class Thread implements RunnableInterface
{
    /** @var  RunnableInterface */
    protected $target;

    /**
     * Thread constructor.
     * @param RunnableInterface|callable $target
     */
    public function __construct($target = null)
    {
        if (is_callable($target)) {
            $this->target = new CallbackRunnable($target);
        } else {
            $this->target = $target;
        }
    }

    public function run(): void
    {
        if ($this->target) {
            $this->target->run();
        }
    }

    public function start()
    {
        $this->run();
    }

    public static function sleep($seconds): void
    {
        sleep($seconds);
    }
}