<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\GanttChart;

use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\MermaidInterface;
use BeastBytes\Mermaid\RenderItemsTrait;
use Stringable;

final class GanttChart implements MermaidInterface, Stringable
{
    use RenderItemsTrait;

    private const TYPE = 'gantt';

    /** @psalm-var list<Milestone|Section|Task> array  */
    private array $items = [];

    public function __construct(
        private readonly string $title = '',
        private readonly string $dateFormat = '',
        private readonly string $axisFormat = '',
        private readonly string $excludes = '',
        private readonly string $tickInterval = '',
        private readonly string $weekday = '',
        private readonly bool $compact = false
    )
    {
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function addItem(Milestone|Section|Task ...$item): self
    {
        $new = clone $this;
        $new->items = array_merge($new->items, $item);
        return $new;
    }

    public function withItem(Milestone|Section|Task ...$item): self
    {
        $new = clone $this;
        $new->items = $item;
        return $new;
    }

    public function render(): string
    {
        $output = [];

        if ($this->compact) {
            $output[] = '---';
            $output[] = 'displayMode: compact';
            $output[] = '---';
        }

        $output[] = self::TYPE;

        foreach (['title', 'dateFormat', 'axisFormat', 'excludes', 'tickInterval', 'weekday'] as $param) {
            if ($this->$param !== '') {
                $output[] = Mermaid::INDENTATION . $param . ' ' . $this->$param;
            }
        }

        $output[] = '';
        $output[] = $this->renderItems($this->items, '');

        return Mermaid::render($output);
    }
}
