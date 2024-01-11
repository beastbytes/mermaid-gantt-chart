<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\GanttChart;

use InvalidArgumentException;

final class Task
{
    public function __construct(
        protected readonly string $title,
        protected readonly string $enduration,
        protected readonly string $start = '',
        protected readonly string $id = '',
        private readonly bool $isActive = false,
        private readonly bool $isCritical = false,
        private readonly bool $isDone = false
    )
    {
        if ($this->isActive && $this->isDone) {
            throw new InvalidArgumentException('`isActive` and `isDone` can not both be true');
        }
    }

    public function render(string $indentation): string
    {
        return $indentation
            . $this->title
            . ' :'
            . ($this->isCritical ? 'crit, ' : '')
            . ($this->isActive ? 'active, ' : '')
            . ($this->isDone ? 'done, ' : '')
            . ($this->id === '' ? '' : $this->id . ', ')
            . ($this->start === '' ? '' : $this->start . ', ')
            . $this->enduration
        ;
    }
}
