<?php

/**
 * An Exception that is thrown when we access DB at runtime when we didn't want to
 */

declare(strict_types=1);

namespace Tests\Exceptions;

use RuntimeException;

class DatabaseAccessException extends RuntimeException {}
