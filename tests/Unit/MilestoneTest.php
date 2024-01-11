<?php

use BeastBytes\Mermaid\GanttChart\Milestone;

test('milestone', function () {
    expect(
        (new Milestone('Functionality added', '2014-01-25', '0d'))
            ->render('')
    )
        ->toBe('Functionality added :milestone, 2014-01-25, 0d')
        ->and(
            (new Milestone('Functionality added', '2014-01-25', '0d', 'ms1'))
                ->render('')
        )
        ->toBe('Functionality added :milestone, ms1, 2014-01-25, 0d')
    ;
});
