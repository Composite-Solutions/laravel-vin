<?php

namespace Composite\LaravelVin;

use Composite\LaravelVin\Services\CountryService;
use Composite\LaravelVin\Services\ManufacturerService;
use Composite\LaravelVin\Services\ModelYearService;
use Composite\LaravelVin\Services\RegionService;
use Exception;
use InvalidArgumentException;

class Vin
{
    public const REGEX = '/^(?<wmi>[0-9A-HJ-NPR-Z]{3})(?<vds>[0-9A-HJ-NPR-Z]{6})(?<vis>[0-9A-HJ-NPR-Z]{8})$/';
    private string $vin;
    private string $wmi;
    private string $vds;
    private string $vis;
    private string $region;
    private string $country;
    private string $manufacturer;
    private mixed $modelYear;
    private ModelYearService $modelYearService;
    private ManufacturerService $manufacturerService;
    private RegionService $regionService;
    private CountryService $countryService;

    public function __construct()
    {
        $this->modelYearService = new ModelYearService();
        $this->manufacturerService = new ManufacturerService();
        $this->regionService = new RegionService();
        $this->countryService = new CountryService();
    }

    /**
     * @param string $vin
     * @return bool
     */
    public function validate(string $vin): bool
    {
        return preg_match(self::REGEX, $vin, $matches);
    }

    /**
     * @param string $vin
     * @return $this
     * @throws Exception
     */
    public function parse(string $vin): static
    {
        $vin = strtoupper($vin);
        if (!preg_match(self::REGEX, $vin, $matches)) {
            throw new InvalidArgumentException(sprintf(
                'The value "%s" is not a valid VIN',
                $vin
            ));
        }

        $this->vin = $vin;
        $this->wmi = $matches['wmi'];
        $this->vds = $matches['vds'];
        $this->vis = $matches['vis'];
        $this->manufacturer = $this->manufacturerService->getManufacturerFromWmi($this->wmi);
        $this->modelYear = $this->modelYearService->getModelYearFromVis($this->vis);
        $this->region = $this->regionService->getRegionFromWmi($this->wmi);
        $this->country = $this->countryService->getCountryFromWmi($this->wmi);
        return $this;
    }

    /**
     * @param string|null $vin
     * @return string
     */
    public function getVin(string $vin = null): string
    {
        return $vin ?? $this->vin;
    }

    /**
     * @param string|null $vin
     * @return string
     * @throws Exception
     */
    public function getWmi(string $vin = null): string
    {
        return $vin ? $this->parse($vin)->wmi :
            ($this->wmi ?: throw new InvalidArgumentException('VIN is not set'));
    }

    /**
     * @param string|null $vin
     * @return string
     * @throws Exception
     */
    public function getVds(string $vin = null): string
    {
        return $vin ? $this->parse($vin)->vds :
            ($this->vds ?: throw new InvalidArgumentException('VIN is not set'));
    }

    /**
     * @param string|null $vin
     * @return string
     * @throws Exception
     */
    public function getVis(string $vin = null): string
    {
        return $vin ? $this->parse($vin)->vis :
            ($this->vis ?: throw new InvalidArgumentException('VIN is not set'));
    }

    /**
     * @param string|null $vin
     * @return string
     * @throws Exception
     */
    public function getManufacturer(string $vin = null): string
    {
        return $vin ? $this->parse($vin)->manufacturer :
            ($this->manufacturer ?: throw new InvalidArgumentException('VIN is not set'));
    }

    /**
     * @param string|null $vin
     * @return array
     * @throws Exception
     */
    public function getModelYear(string $vin = null): array
    {
        return $vin ? $this->parse($vin)->modelYear :
            ($this->modelYear ?: throw new InvalidArgumentException('VIN is not set'));
    }

    /**
     * @param string|null $vin
     * @return string
     * @throws Exception
     */
    public function getRegion(string $vin = null): string
    {
        return $vin ? $this->parse($vin)->region :
            ($this->region ?: throw new InvalidArgumentException('VIN is not set'));
    }

    /**
     * @param string|null $vin
     * @return string
     * @throws Exception
     */
    public function getCountry(string $vin = null): string
    {
        return $vin ? $this->parse($vin)->country :
            ($this->country ?: throw new InvalidArgumentException('VIN is not set'));
    }

    /**
     * @param string|null $vin
     * @return array
     * @throws Exception
     */
    public function toArray(string $vin = null): array
    {
        if($vin) $this->parse($vin);

        return [
            'vin' => $this->vin,
            'wmi' => $this->wmi,
            'vds' => $this->vds,
            'vis' => $this->vis,
            'manufacturer' => $this->manufacturer,
            'modelYear' => $this->modelYear,
            'region' => $this->region,
            'country' => $this->country,
        ];
    }

    /**
     * @return string
     * @throws Exception
     */
    public function __toString(): string
    {
        return json_encode($this->toArray());
    }
}
