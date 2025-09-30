<?php

/**
 * Adds the ability to mention there is a todo
 */

declare(strict_types=1);

namespace Tests\Concerns;

trait HasTodo
{
    /**
     * marks a test as incomplete with a useful message
     */
    protected function todo(): void
    {
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];
        $this->markTestIncomplete(sprintf('Todo: %s::%s', $caller['class'], $caller['function']));
    }
}
