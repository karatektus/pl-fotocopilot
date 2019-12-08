<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class AssetTwigExtension
 *
 * @package App\Twig
 */
class FileTwigExtension extends AbstractExtension
{

    /**
     * Get Filters
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new TwigFilter('file_version', [
                $this,
                'getFileVersion',
            ]),
        ];
    }

    /**
     * File Version
     *
     * @param string $fileName
     *
     * @return string
     */
    public function getFileVersion($fileName)
    {
        if ('/' === substr($fileName, 0, 1)) {
            $fileNameLocal = substr($fileName, 1);
        } else {
            $fileNameLocal = $fileName;
        }

        $filePath = sprintf('%s/../../public/%s', __DIR__, $fileNameLocal);
        if (true === file_exists($filePath)) {
            return sprintf('%s?v=%s', $fileName, substr(md5_file($filePath), 0, 6));
        }

        return sprintf('%s?v=%s', $fileName, substr(sha1(microtime()), 0, 6));
    }
}