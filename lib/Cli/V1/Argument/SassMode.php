<?php
declare(strict_types=1);

namespace Zarthus\Sass\Cli\V1\Argument;

enum SassMode {
    case None;
    case OneToOne;
    case ManyToMany;
}
