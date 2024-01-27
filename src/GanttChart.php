<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\GanttChart;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\InteractionRendererTrait;
use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\MermaidInterface;
use BeastBytes\Mermaid\RenderItemsTrait;
use Stringable;

final class GanttChart implements MermaidInterface, Stringable
{
    use CommentTrait;
    use InteractionRendererTrait;
    use RenderItemsTrait;

    private const TYPE = 'gantt';

    /** @psalm-var list<Milestone|Section|Task> array  */
    private array $items = [];
    /** @psalm-var list<Task> array  */
    private array $tasks = [];

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

        foreach ($item as $i) {
            if ($i instanceof Task) {
                $this->tasks[] = $i;
            }
        }

        return $new;
    }

    public function withItem(Milestone|Section|Task ...$item): self
    {
        $new = clone $this;
        $new->items = $item;

        foreach ($item as $i) {
            if ($i instanceof Task) {
                $this->tasks[] = $i;
            }
        }

        return $new;
    }

    public function render(array $attributes = []): string
    {
        $output = [];

        if ($this->compact) {
            $output[] = '---';
            $output[] = 'displayMode: compact';
            $output[] = '---';
        }

        $this->renderComment('', $output);
        $output[] = self::TYPE;

        foreach (['title', 'dateFormat', 'axisFormat', 'excludes', 'tickInterval', 'weekday'] as $param) {
            if ($this->$param !== '') {
                $output[] = Mermaid::INDENTATION . $param . ' ' . $this->$param;
            }
        }

        $output[] = '';
        $this->renderItems($this->items, '', $output);
        $this->renderInteractions($this->tasks, $output);

        return Mermaid::render($output, $attributes);
    }
}
