<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\GanttChart;

enum TaskStatus: string
{
    case Active = 'active, ';
    case Critical = 'crit, ';
    case CriticalActive = 'crit, active, ';
    case CriticalDone = 'crit, done, ';
    case Done = 'done, ';

}
