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
 * Windows
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Windows implements EnvironmentInterface
{
    private \COM $wmi;

    public function __construct()
    {
        $this->wmi = new \COM('WinMgmts:\\\\.');
    }

    public function getCpuUsage(): float
    {
        $cpus = $this->wmi->InstancesOf('Win32_Processor');
        $load = 0;
        foreach ($cpus as $cpu) {
            $load += $cpu->LoadPercentage;
        }

        return $load;
    }

    public function getMemoryUsage(): float
    {
        $result = $this->wmi->ExecQuery('SELECT FreePhysicalMemory, TotalVisibleMemorySize FROM Win32_OperatingSystem');
        $row = $result->ItemIndex(0);
        $total = round($row->TotalVisibleMemorySize / 1000000,2);
        $available = round($row->FreePhysicalMemory / 1000000,2);
        $used = round($total - $available,2);

        return round(($used / $total) * 100, 2);
    }
}
