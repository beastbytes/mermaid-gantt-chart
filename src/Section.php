<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\GanttChart;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\RenderItemsTrait;

final class Section
{
    use CommentTrait;
    use RenderItemsTrait;

    private const TYPE = 'section';

    /** @psalm-var list<Milestone|Task> array  */
    private array $items = [];
    /** @psalm-var list<Task> array  */
    private array $tasks = [];

    public function __construct(private readonly string $title)
    {
    }

    public function addItem(Milestone|Task ...$item): self
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

    public function withItem(Milestone|Task ...$item): self
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

    public function render(string $indentation): string
    {
        $output = [];

        $this->renderComment($indentation, $output);
        $output[] = $indentation . self::TYPE . ' ' . $this->title;
        $this->renderItems($this->items, $indentation, $output);

        return implode("\n", $output);
    }
}
