<?php

namespace App\Support\Imports;

use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

trait ParsesExcelDates
{
    protected function parseExcelDate($value, string $outputFormat = 'Y-m-d'): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof \DateTimeInterface) {
            return Carbon::instance($value)->format($outputFormat);
        }

        if (is_numeric($value)) {
            return ExcelDate::excelToDateTimeObject((float) $value)->format($outputFormat);
        }

        $value = trim((string) $value);
        $formats = ['d/m/Y', 'd-m-Y', 'Y-m-d', 'm/d/Y', 'm-d-Y', 'd.m.Y', 'd/m/y', 'd-m-y'];

        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $value)->format($outputFormat);
            } catch (\Throwable $throwable) {
                //
            }
        }

        try {
            return Carbon::parse($value)->format($outputFormat);
        } catch (\Throwable $throwable) {
            return null;
        }
    }
}
