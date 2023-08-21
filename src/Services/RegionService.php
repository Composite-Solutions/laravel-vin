<?php

namespace Composite\LaravelVin\Services;

use Exception;

class RegionService
{

    /**
     * @param string $wmi
     * @return string
     * @throws Exception
     */
    public function getRegionFromWmi(string $wmi): string
    {
        $character = $wmi[0];

        return match ($character) {
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H' => 'Africa',
            'J', 'K', 'L', 'M', 'N', 'P', 'R' => 'Asia',
            'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' => 'Europe',
            '1', '2', '3', '4', '5' => 'North America',
            '6', '7' => 'Oceania',
            '8', '9', '0' => 'South America',
            default => throw new Exception('Invalid VIN or region not covered in mapping.'),
        };
    }
}
