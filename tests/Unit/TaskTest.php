<?php

use BeastBytes\Mermaid\GanttChart\Task;
use BeastBytes\Mermaid\GanttChart\TaskStatus;

defined('COMMENT') or define('COMMENT', 'comment');

test('Task test', function () {
    expect(
        (new Task('Completed task in the critical line', '2014-01-08'))
            ->render('')
    )
        ->toBe('Completed task in the critical line :'
            . 'id_' . md5('Completed task in the critical line') . ', '
            . '2014-01-08'
        )
        ->and(
            (new Task('Completed task in the critical line', '2014-01-08', '2014-01-01'))
                ->render('')
        )
        ->toBe('Completed task in the critical line :'
            . 'id_' . md5('Completed task in the critical line') . ', '
            . '2014-01-01, 2014-01-08'
        )
        ->and(
            (new Task('Completed task in the critical line', '5d', '2014-01-01'))
                ->render('')
        )
        ->toBe('Completed task in the critical line :'
            . 'id_' . md5('Completed task in the critical line') . ', '
            . '2014-01-01, 5d'
        )
        ->and(
            (new Task('Completed task in the critical line', '5d', '2014-01-01', 'ct1'))
                ->render('')
        )
        ->toBe('Completed task in the critical line :ct1, 2014-01-01, 5d')
        ->and(
            (new Task(
                title:      'Completed task in the critical line',
                enduration: '5d',
                start:      '2014-01-01',
                id:         'ct1',
                status:     TaskStatus::CriticalDone
            ))
                ->render('')
        )
        ->toBe('Completed task in the critical line :crit, done, ct1, 2014-01-01, 5d')
    ;

    $output = [];
    $task = (new Task(
        title:      'Active task in the critical line',
        enduration: '5d',
        start:      '2014-01-01',
        id:         'ct1',
        status:     TaskStatus::Active
    ))
        ->withComment(COMMENT)
        ->withInteraction('https://example.com')
    ;

    expect($task->render(''))
        ->toBe('%% ' . COMMENT . "\n"
            . 'Active task in the critical line :active, ct1, 2014-01-01, 5d'
        )
    ;

    $task->renderInteraction($output);
    expect($output[0])
        ->toBe('  click ct1 href "https://example.com" _self')
    ;
});
