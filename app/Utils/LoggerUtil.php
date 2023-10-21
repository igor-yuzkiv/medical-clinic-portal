<?php

namespace App\Utils;

/**
 *
 */
final class LoggerUtil
{
    /**
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function info(string $message, array $context = []): void
    {
        logger()->info($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function error(string $message, array $context = []): void
    {
        logger()->error($message, $context);
    }

    /**
     * @param \Exception $exception
     * @param string|null $message
     * @return void
     */
    public static function exception(\Exception $exception): void
    {
        self::error(self::exceptionToText($exception));
    }

    /**
     * @param mixed $variable
     * @return void
     */
    public static function variable($variable): void
    {
        self::info(print_r($variable, true));
    }

    /**
     * @param \Exception $exception
     * @return string
     */
    public static function exceptionToText(\Exception $exception): string
    {
        return
            "type: " . get_class($exception) . PHP_EOL .
            "| code: " . $exception->getCode() . PHP_EOL .
            "| message: " . $exception->getMessage() . PHP_EOL .
            "| file: " . $exception->getFile() . PHP_EOL .
            "| line: " . $exception->getLine() . PHP_EOL .
            "| trace" . $exception->getTraceAsString();
    }
}
