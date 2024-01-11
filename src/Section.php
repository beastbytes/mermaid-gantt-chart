<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\GanttChart;

use BeastBytes\Mermaid\RenderItemsTrait;

final class Section
{
    use RenderItemsTrait;

    private const TYPE = 'section';

    /** @psalm-var list<Milestone|Task> array  */
    private array $items = [];

    public function __construct(private readonly string $title)
    {
    }

    public function addItem(Milestone|Task ...$item): self
    {
        $new = clone $this;
        $new->items = array_merge($new->items, $item);
        return $new;
    }

    public function withItem(Milestone|Task ...$item): self
    {
        $new = clone $this;
        $new->items = $item;
        return $new;
    }

    public function render(string $indentation): string
    {
        $output = [];

        $output[] = $indentation . self::TYPE . ' ' . $this->title;
        $output[] = $this->renderItems($this->items, $indentation);

        return implode("\n", $output);
    }
}
