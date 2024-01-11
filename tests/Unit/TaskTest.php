<?php

use BeastBytes\Mermaid\GanttChart\Task;

test('Task test', function () {
    expect(
        (new Task('Completed task in the critical line', '2014-01-08'))
            ->render('')
    )
        ->toBe('Completed task in the critical line :2014-01-08')
        ->and(
            (new Task('Completed task in the critical line', '2014-01-08', '2014-01-01'))
                ->render('')
        )
        ->toBe('Completed task in the critical line :2014-01-01, 2014-01-08')
        ->and(
            (new Task('Completed task in the critical line', '5d', '2014-01-01'))
                ->render('')
        )
        ->toBe('Completed task in the critical line :2014-01-01, 5d')
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
                isCritical: true,
                isDone:     true
            ))
                ->render('')
        )
        ->toBe('Completed task in the critical line :crit, done, ct1, 2014-01-01, 5d')
        ->and(
            (new Task(
                title:      'Active task in the critical line',
                enduration: '5d',
                start:      '2014-01-01',
                id:         'ct1',
                isActive:   true
            ))
                ->render('')
        )
        ->toBe('Active task in the critical line :active, ct1, 2014-01-01, 5d')
    ;
});
