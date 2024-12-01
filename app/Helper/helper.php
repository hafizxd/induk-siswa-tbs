<?php

use Carbon\Carbon;

function convertDateFormat($date, $fromFormat, $toFormat = 'Y-m-d') {
    if (empty($date)) {
        return null;
    }

    $formats = [
        'Y-m-d',
        'd/m/Y',
        'm-d-Y',
        'd-m-Y',
        'Y/m/d',
        'Ymd',
        'Y-M-d',  // Other potential formats
        'm/d/Y',
        'd M Y',
        'D, d M Y H:i:s T', // For example, RFC2822 format
        'Y-m-d H:i:s',      // Datetime format
    ];

    foreach ($formats as $format) {
        try {
            if ($format == $fromFormat) {
                $parsedDate = Carbon::createFromFormat($fromFormat, $date, 'Asia/Jakarta');
                return $parsedDate->format($toFormat);
            }
        } catch (\Throwable $th) {
            continue;
        }
    }

    return null;
}