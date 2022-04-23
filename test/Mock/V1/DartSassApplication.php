<?php

namespace Mock;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;

final class DartSassApplication extends SingleCommandApplication
{
    private const OPTIONS = [
        'update',
        ['i', 'interactive'],
        ['w', 'watch'],
    ];
    private const BOOLEAN_OPTIONS = [
        'stdin',
        'indented',
        'charset',
        'error-css',
        'source-map',
        'embed-sources',
        'embed-source-map',
        'poll',
        'stop-on-error',
        ['c', 'color'],
        'unicode',
        ['q', 'quiet'],
        'quiet-deps',
        //'verbose', // sf already provides this
        'trace',
        //'quiet', // sf already provides this
    ];
    private const OPTIONS_WITH_ARGUMENTS = [
        ['I', 'load-path'],
        ['s', 'style'],
        'source-map-urls',
    ];

    public function __construct(string $name = 'sass')
    {
        parent::__construct($name);

        $this->setVersion('1.5.0')
            ->setDescription('dart-sass mirror mock')
            ->setAutoExit(false);
    }

    protected function execute(
        InputInterface $input, OutputInterface $output
    ) {
        if ($input->getOption('help')) {
            $output->writeln($this->getHelp());
            return 0;
        }

        if (empty($input->getArgument('input'))) {
            $output->writeln('error: missing input');
            return 1;
        }

        return 0;
    }

    protected function configure()
    {
        parent::configure();

        $this->setName('sass');
        $this->addArgument('input', InputArgument::IS_ARRAY, 'input.scss> [output.css] | <input.scss>:<output.css> <input/>:<output/> <dir/>');

        $this->addOption('help', 'h', InputOption::VALUE_NONE, 'Show this help command');
        $this->addOptions(self::OPTIONS, InputOption::VALUE_NONE, false);
        $this->addOptions(self::BOOLEAN_OPTIONS, InputOption::VALUE_NONE, true);
        $this->addOptions(self::OPTIONS_WITH_ARGUMENTS, InputOption::VALUE_REQUIRED, false);
    }

    private function addOptions(array $options, int $inputOption, bool $negator): void
    {
        foreach ($options as $option) {
            if (is_array($option)) {
                $this->addOption($option[1], $option[0], $inputOption);
                if ($negator) {
                    $this->addOption('no-' . $option[1], null, $inputOption);
                }
            } else {
                $this->addOption($option, null, $inputOption);
                if ($negator) {
                    $this->addOption('no-' . $option, null, $inputOption);
                }
            }
        }
    }

    public function getUsages(): array
    {
        return [];
    }

    public function getSynopsis(bool $short = false): string
    {
        return <<<HELP
Usage: sass <input.scss> [output.css]
       sass <input.scss>:<output.css> <input/>:<output/> <dir/>

━━━ Input and Output ━━━━━━━━━━━━━━━━━━━
    --[no-]stdin               Read the stylesheet from stdin.
    --[no-]indented            Use the indented syntax for input from stdin.
-I, --load-path=<PATH>         A path to use when resolving imports.
                               May be passed multiple times.
-s, --style=<NAME>             Output style.
                               [expanded (default), compressed]
    --[no-]charset             Emit a @charset or BOM for CSS with non-ASCII characters.
                               (defaults to on)
    --[no-]error-css           When an error occurs, emit a stylesheet describing it.
                               Defaults to true when compiling to a file.
    --update                   Only compile out-of-date stylesheets.

━━━ Source Maps ━━━━━━━━━━━━━━━━━━━━━━━━
    --[no-]source-map          Whether to generate source maps.
                               (defaults to on)
    --source-map-urls          How to link from source maps to source files.
                               [relative (default), absolute]
    --[no-]embed-sources       Embed source file contents in source maps.
    --[no-]embed-source-map    Embed source map contents in CSS.

━━━ Other ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
-w, --watch                    Watch stylesheets and recompile when they change.
    --[no-]poll                Manually check for changes rather than using a native watcher.
                               Only valid with --watch.
    --[no-]stop-on-error       Don't compile more files once an error is encountered.
-i, --interactive              Run an interactive SassScript shell.
-c, --[no-]color               Whether to use terminal colors for messages.
    --[no-]unicode             Whether to use Unicode characters for messages.
-q, --[no-]quiet               Don't print warnings.
    --[no-]quiet-deps          Don't print compiler warnings from dependencies.
                               Stylesheets imported through load paths count as dependencies.
    --[no-]verbose             Print all deprecation warnings even when they're repetitive.
    --[no-]trace               Print full Dart stack traces for exceptions.
-h, --help                     Print this usage information.
    --version                  Print the version of Dart Sass.
HELP;
    }
}
