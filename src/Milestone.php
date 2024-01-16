<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\GanttChart;

use BeastBytes\Mermaid\CommentTrait;

final class Milestone
{
    use CommentTrait;

    public function __construct(
        readonly string $title,
        readonly string $when,
        readonly string $duration = '',
        readonly string $id = ''
    )
    {
    }

    public function render(string $indentation): string
    {
        $output = [];

        $this->renderComment($indentation, $output);
        $output[] = $indentation
            . $this->title
            . ' :milestone,'
            . ($this->id === '' ? '' : ' ' . $this->id . ',')
            . ' ' . $this->when . ','
            . ' ' . $this->duration
        ;

        return implode("\n", $output);
    }
}
