<?php

use BeastBytes\Mermaid\GanttChart\Milestone;

defined('COMMENT') or define('COMMENT', 'comment');

test('milestone', function () {
    expect(
        (new Milestone('Functionality added', '2014-01-25', '0d'))
            ->render('')
    )
        ->toBe('Functionality added :milestone, 2014-01-25, 0d')
        ->and(
            (new Milestone('Functionality added', '2014-01-25', '0d', 'ms1'))
                ->withComment(COMMENT)
                ->render('')
        )
        ->toBe('%% ' . COMMENT . "\nFunctionality added :milestone, ms1, 2014-01-25, 0d")
    ;
});
