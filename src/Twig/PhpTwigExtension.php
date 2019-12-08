<?php


namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class PhpTwigExtension
 *
 * @package App\Twig
 */
class PhpTwigExtension extends AbstractExtension
{
    /**
     * @return array|TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('array_keys',
                [
                    $this,
                    'array_keys',
                ]
            ),
            new TwigFilter('getenv',
                [
                    $this,
                    'getenv',
                ]
            ),
            new TwigFilter('sha1',
                [
                    $this,
                    'sha1',
                ]
            ),
            new TwigFilter('str_pad',
                [
                    $this,
                    'str_pad',
                ]
            ),
        ];
    }

    /**
     * Array Keys
     *
     * @param array $array
     *
     * @return array
     */
    public function array_keys(array $array): array
    {
        return array_keys($array);
    }

    /**
     * Getenv
     *
     * @param string $key
     *
     * @return bool|mixed
     */
    public function getenv(string $key)
    {
        if (true === isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        return false;
    }

    /**
     * Sha1
     *
     * @param string $value
     *
     * @return string
     */
    public function sha1(string $value)
    {
        return sha1($value);
    }

    /**
     * Str_pad
     *
     * @param string $input
     * @param int    $padLength
     * @param string $padString
     *
     * @return string
     */
    public function str_pad(string $input, int $padLength, string $padString = ''): string
    {
        return $this->str_pad($input, $padLength, $padString);
    }

}