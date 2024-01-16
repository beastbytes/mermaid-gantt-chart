<?php

use BeastBytes\Mermaid\GanttChart\Milestone;
use BeastBytes\Mermaid\GanttChart\Section;
use BeastBytes\Mermaid\GanttChart\Task;
use BeastBytes\Mermaid\GanttChart\TaskStatus;

defined('COMMENT') or define('COMMENT', 'comment');

test('example', function () {
    $output = [];

    expect((new Section('Critical tasks'))
        ->withComment(COMMENT)
        ->withItem(
            new Task(
                'Completed task in the critical line',
                '24h',
                '2014-01-06',
                status: TaskStatus::CriticalDone
            ),
            new Task(
                'Implement parser and json',
                '2d',
                'after des1',
                status: TaskStatus::CriticalDone
            ),
            new Task('Create tests for parser', '3d', status: TaskStatus::CriticalActive),
            new Task('Future task in critical line', '5d', status: TaskStatus::Critical),
            new Task('Create tests for renderer', '2d'),
            $task = (new Task('Add to mermaid', '1d'))->withInteraction('https://example.com'),
            new Milestone('Functionality added', '2014-01-25', '0d')
        )
        ->render('')
    )
    ->toBe('%% ' . COMMENT . "\n"
        . "section Critical tasks\n"
        . '  Completed task in the critical line :crit, done, id_' . md5('Completed task in the critical line') . ", 2014-01-06, 24h\n"
        . '  Implement parser and json :crit, done, id_' . md5('Implement parser and json') . ", after des1, 2d\n"
        . '  Create tests for parser :crit, active, id_' . md5('Create tests for parser') . ", 3d\n"
        . '  Future task in critical line :crit, id_' . md5('Future task in critical line') . ", 5d\n"
        . '  Create tests for renderer :id_' . md5('Create tests for renderer') . ", 2d\n"
        . '  Add to mermaid :id_' . md5('Add to mermaid') . ", 1d\n"
        . "  Functionality added :milestone, 2014-01-25, 0d"
    );

    $task->renderInteraction($output);
    expect($output[0])
        ->toBe('  click id_' . md5('Add to mermaid') . ' href "https://example.com" _self')
    ;
});
