<?php
declare(strict_types=1);

namespace Po2Json\Commands;

use DirectoryIterator;
use Gettext\Translations;
use InvalidArgumentException;
use SplFileInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Convert extends Command
{
    protected static $defaultName = 'po2json';

    public function configure()
    {
        $this->setName('po2json');
        $this->setDescription('Converts set of *.po files to the set of *.json dictionary files.');
        $this->setHelp('Run po2json -h|--help for more info.');

        $this->addUsage('-i /home/po/ -o /home/json');
        $this->addUsage('-h');

        $this->addOption('input', 'i', InputOption::VALUE_REQUIRED, 'Directory where po files are located.');
        $this->addOption('output', 'o', InputOption::VALUE_REQUIRED, 'Directory to put converted json files.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $inputDirectory = $input->getOption('input');
        $outputDirectory = $input->getOption('output');

        try {
            $this->validateInputDirectory($inputDirectory);
            $this->validateOutputDirectory($outputDirectory);
        } catch (InvalidArgumentException $exception) {
            $output->writeln(
                sprintf('%s: %s', $this->getName(), $exception->getMessage())
            );
            $output->writeln('');
            $output->writeln(
                sprintf('Usage: %s', $this->getSynopsis())
            );
            exit(1);
        }

        try {
            $this->convert($inputDirectory, $outputDirectory, $output);
        } catch(\Exception $exception) {
            $output->writeln(
                sprintf('%s: %s', $this->getName(), $exception->getMessage())
            );
            exit(1);
        }

        $output->writeln('Conversion is done.');
    }

    private function validateInputDirectory(?string $directory): void
    {
        if (!$directory) {
            throw new InvalidArgumentException('[-i|--input INPUT] parameter is required.');
        }

        if (!file_exists($directory)) {
            throw new InvalidArgumentException("Input directory: {$directory} does not exist.");
        }
    }

    private function validateOutputDirectory(?string $directory): void
    {
        if (!$directory) {
            throw new InvalidArgumentException('[-o|--output OUTPUT] parameter is required.');
        }

        if (!file_exists($directory)) {
            throw new InvalidArgumentException("Output directory: {$directory} does not exist.");
        }
    }

    private function convert(string $inputDirectory, string $outputDirectory, OutputInterface $output): void
    {
        // Load data from json dictionary file
        $iterator = new DirectoryIterator($inputDirectory);

        /**
         * @var SplFileInfo $file
         */
        foreach ($iterator as $file) {
            if ($file->getExtension() !== 'po') {
                continue;
            }

            $inputFile = "{$inputDirectory}{$file->getBasename()}";
            $outputFile = "{$outputDirectory}{$file->getBasename('.po')}.json";

            $output->writeln("Converting {$inputFile} -> {$outputFile}");

            /**
             * @var Translations $translations
             */
            $translations = Translations::fromPoFile($inputFile);
            $translations->toJsonDictionaryFile($outputFile);

            //TODO: make payload
        }
    }
}
