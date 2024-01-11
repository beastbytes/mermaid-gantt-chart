<?php

use BeastBytes\Mermaid\GanttChart\GanttChart;
use BeastBytes\Mermaid\GanttChart\Milestone;
use BeastBytes\Mermaid\GanttChart\Section;
use BeastBytes\Mermaid\GanttChart\Task;

test('example', function () {
    expect(
        (new GanttChart(
            title: 'Adding GANTT diagram functionality to mermaid',
            dateFormat: 'YYYY-MM-DD',
            excludes: 'weekends'
        ))
        ->withItem(
            (new Section('A section'))
                ->withItem(
                    new Task(
                        title:      'Completed task',
                        enduration: '2014-01-08',
                        start:      '2014-01-06',
                        id:         'des1',
                        isDone:     true
                    ),
                    new Task(
                        title:      'Active task',
                        enduration: '3d',
                        start:      '2014-01-09',
                        id:         'des2',
                        isActive:   true
                    ),
                    new Task(
                        title:      'Future task',
                        enduration: '5d',
                        start:      'after des2',
                        id:         'des3'
                    ),
                    new Task(
                        title:      'Future task2',
                        enduration: '5d',
                        start:      'after des3',
                        id:         'des4'
                    )
                )
            ,
            (new Section('Critical tasks'))
                ->withItem(
                    new Task('Completed task in the critical line', '24h', '2014-01-06', isCritical: true, isDone: true),
                    new Task('Implement parser and jison', '2d', 'after des1', isCritical: true, isDone: true),
                    new Task('Create tests for parser', '3d', isCritical: true, isActive: true),
                    new Task('Future task in critical line', '5d', isCritical: true),
                    new Task('Create tests for renderer', '2d'),
                    new Task('Add to mermaid', '1d'),
                    new Milestone('Functionality added', '2014-01-25', '0d')
                )
            ,
            (new Section('Documentation'))
                ->withItem(
                    new Task('Describe gantt syntax', '3d', 'after des1', 'a1', isActive: true),
                    new Task('Add gantt diagram to demo page', '20h', 'after a1'),
                    new Task('Add another diagram to demo page', '48h', 'after a1', 'doc1')
                )
            ,
            (new Section('Last section'))
                ->withItem(
                    new Task('Describe gantt syntax', '3d', 'after doc1'),
                    new Task('Add gantt diagram to demo page', '20h'),
                    new Task('Add another diagram to demo page', '48h')
                )
        )
        ->render()
    )
        ->toBe(
            "<pre class=\"mermaid\">\n"
            . "gantt\n"
            . "  title Adding GANTT diagram functionality to mermaid\n"
            . "  dateFormat YYYY-MM-DD\n"
            . "  excludes weekends\n"
            . "\n"
            . "  section A section\n"
            . "    Completed task :done, des1, 2014-01-06, 2014-01-08\n"
            . "    Active task :active, des2, 2014-01-09, 3d\n"
            . "    Future task :des3, after des2, 5d\n"
            . "    Future task2 :des4, after des3, 5d\n"
            . "  section Critical tasks\n"
            . "    Completed task in the critical line :crit, done, 2014-01-06, 24h\n"
            . "    Implement parser and jison :crit, done, after des1, 2d\n"
            . "    Create tests for parser :crit, active, 3d\n"
            . "    Future task in critical line :crit, 5d\n"
            . "    Create tests for renderer :2d\n"
            . "    Add to mermaid :1d\n"
            . "    Functionality added :milestone, 2014-01-25, 0d\n"
            . "  section Documentation\n"
            . "    Describe gantt syntax :active, a1, after des1, 3d\n"
            . "    Add gantt diagram to demo page :after a1, 20h\n"
            . "    Add another diagram to demo page :doc1, after a1, 48h\n"
            . "  section Last section\n"
            . "    Describe gantt syntax :after doc1, 3d\n"
            . "    Add gantt diagram to demo page :20h\n"
            . "    Add another diagram to demo page :48h\n"
            . '</pre>'
        );
});
