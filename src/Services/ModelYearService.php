<?php

namespace Composite\LaravelVin\Services;

class ModelYearService
{
    private mixed $years;

    public function __construct()
    {
        $this->years = include __DIR__ . '/../../data/years.php';
    }

    /**
     * @param string $vis
     * @return array
     */
    public function getModelYearFromVis(string $vis): array
    {
        $comingYear = now()->addYear()->format('Y');
        $estimatedYears = [];

        foreach ($this->years as $year => $char) {
            if ($vis[0] === $char) {
                $estimatedYears[] = $year;
            }

            if ($comingYear === $year) {
                break;
            }
        }

        return $estimatedYears;
    }
}
