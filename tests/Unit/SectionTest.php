<?php

use BeastBytes\Mermaid\GanttChart\Milestone;
use BeastBytes\Mermaid\GanttChart\Section;
use BeastBytes\Mermaid\GanttChart\Task;

test('example', function () {
    expect((new Section('Critical tasks'))
        ->withItem(
            new Task('Completed task in the critical line', '24h', '2014-01-06', isCritical: true, isDone: true),
            new Task('Implement parser and jison', '2d', 'after des1', isCritical: true, isDone: true),
            new Task('Create tests for parser', '3d', isCritical: true, isActive: true),
            new Task('Future task in critical line', '5d', isCritical: true),
            new Task('Create tests for renderer', '2d'),
            new Task('Add to mermaid', '1d'),
            new Milestone('Functionality added', '2014-01-25', '0d')
        )
        ->render('')
    )
    ->toBe("section Critical tasks\n"
        . "  Completed task in the critical line :crit, done, 2014-01-06, 24h\n"
        . "  Implement parser and jison :crit, done, after des1, 2d\n"
        . "  Create tests for parser :crit, active, 3d\n"
        . "  Future task in critical line :crit, 5d\n"
        . "  Create tests for renderer :2d\n"
        . "  Add to mermaid :1d\n"
        . "  Functionality added :milestone, 2014-01-25, 0d"
    );
});
