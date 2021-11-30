<?php

/**
 * This class loads all variables setted in .env file and store them into $_ENV array
 *
 * PHP version 7.4
 *
 * LICENSE: CC Attribution 4.0 https://creativecommons.org/licenses/by-sa/4.0/
 *
 * @category Environment
 * @package  DotEnvLoader
 * @author   Javier Rodríguez <falces@gmail.com>
 * @license  CC Attribution 4.0 https://creativecommons.org/licenses/by-sa/4.0/
 * @link     https://github.com/falces/EnvLoader
 */

namespace Falces;

use InvalidArgumentException;
use RuntimeException;

/**
 * This class loads all variables setted in .env file and store them into $_ENV array
 *
 * @category Environment
 * @package  DotEnvLoader
 * @author   Javier Rodríguez <falces@gmail.com>
 * @license  CC Attribution 4.0 https://creativecommons.org/licenses/by-sa/4.0/
 * @link     https://github.com/falces/EnvLoader
 */
class DotEnvLoader
{
    protected $path;

    /**
     * Get and check tha path provided and store into $this->path propertry
     *
     * @param string $path Path to env file
     * @param string $file env filename
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        string $path = '',
        string $file = '.env'
    )
    {
        $path .= '/' . $file;

        if (!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf('%s does not exist', $path));
        }

        $this->path = $path;
    }

    /**
     * Read .env file and store variables into $_ENV and $_SERVER arrays
     *
     * @return void
     * @throws RuntimeException
     */
    public function load(): void
    {
        if (!is_readable($this->path)) {
            throw new RuntimeException(
                sprintf('%s file is not readable', $this->path)
            );
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name  = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER)
                && !array_key_exists($name, $_ENV)
            ) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name]    = $value;
                $_SERVER[$name] = $value;
            }
        }
    }

    /**
     * Get the $_ENV variable names
     *
     * @return array
     */
    public function getEnvironmentVariables(): array
    {
        return array_keys($_ENV);
    }
}
