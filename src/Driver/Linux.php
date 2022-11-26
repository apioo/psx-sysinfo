<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace PSX\SysInfo\Driver;

use PSX\SysInfo\EnvironmentInterface;

/**
 * Linux
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Linux implements EnvironmentInterface
{
    public function getCpuUsage(): float
    {
        $load = sys_getloadavg();
        $usage = $load[0] ?? null;

        if (!is_float($usage)) {
            return 0;
        }

        return $usage;
    }

    public function getMemoryUsage(): float
    {
        $return = trim((string) shell_exec('free -k'));
        $lines = explode("\n", $return);
        $parts = array_values(array_filter(explode(' ', $lines[1])));

        if (!isset($parts[1]) || !isset($parts[2])) {
            return 0;
        }

        $total = ((int) $parts[1]) / 1000000;
        $used  = ((int) $parts[2]) / 1000000;

        return round(($used / $total) * 100, 2);
    }
}
