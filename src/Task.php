<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\GanttChart;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\InteractionInterface;
use BeastBytes\Mermaid\InteractionTrait;
use BeastBytes\Mermaid\NodeInterface;

final class Task implements NodeInterface
{
    use CommentTrait;
    use InteractionTrait;

    public function __construct(
        protected readonly string $title,
        protected readonly string $enduration,
        protected readonly string $start = '',
        protected string $id = '',
        protected readonly ?TaskStatus $status = null
    )
    {
        if ($this->id === '') {
            $this->id = 'id_' . md5($this->title);
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function render(string $indentation): string
    {
        $output = [];

        $this->renderComment($indentation, $output);
        $output[] = $indentation
            . $this->title
            . ' :'
            . ($this->status === null ? '' : $this->status->value)
            . $this->id . ', '
            . ($this->start === '' ? '' : $this->start . ', ')
            . $this->enduration
        ;

        return implode("\n", $output);
    }
}
