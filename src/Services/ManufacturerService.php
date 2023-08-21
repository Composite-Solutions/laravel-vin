<?php

namespace Composite\LaravelVin\Services;

class ManufacturerService
{
    private mixed $manufacturers;

    public function __construct()
    {
        $this->manufacturers = include __DIR__ . '/../../data/manufacturers.php';
    }

    /**
     * @param string $wmi
     * @return string
     */
    public function getManufacturerFromWmi(string $wmi): string
    {
        return $this->manufacturers[$wmi] ??
            $this->manufacturers[$wmi[0] . $wmi[1]] ??
            'Unknown';
    }
}
