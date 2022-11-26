<?php

class com {
    public function __construct(string $module_name) {
    }

    /**
     * @return COMCPU[]
     */
    public function InstancesOf(string $name): array {
        return [];
    }

    public function ExecQuery(string $query): COMQueryResult {
        return new COMQueryResult();
    }
}

class COMCPU {
    public int $LoadPercentage;
}

class COMQueryResult {
    public function ItemIndex(int $index): COMQueryRow {
        return new COMQueryRow();
    }
}

class COMQueryRow {
    public int $TotalVisibleMemorySize;
    public int $FreePhysicalMemory;
}
