<?php
declare(strict_types=1);

namespace Po2Json\ValueObjects;

class Parameters
{
    public const DEFAULT_LANG = 'en';

    /**
     * @var string
     */
    private $inputDirectory;

    /**
     * @var string
     */
    private $outputDirectory;

    /**
     * @var bool
     */
    private $apiFormat;

    /**
     * @var string
     */
    private $lang;

    public function __construct(
        string $inputDirectory,
        string $outputDirectory,
        bool $apiFormat = false,
        string $lang = self::DEFAULT_LANG
    ) {
        $this->inputDirectory = $inputDirectory;
        $this->outputDirectory = $outputDirectory;
        $this->apiFormat = $apiFormat;
        $this->lang = $lang;
    }

    /**
     * @return string
     */
    public function getInputDirectory(): string
    {
        return $this->inputDirectory;
    }

    /**
     * @return string
     */
    public function getOutputDirectory(): string
    {
        return $this->outputDirectory;
    }

    /**
     * @return bool
     */
    public function isApiFormat(): bool
    {
        return $this->apiFormat;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }
}
