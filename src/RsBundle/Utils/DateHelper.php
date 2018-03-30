<?php

namespace RsBundle\Utils;

class DateHelper {
    
    /**
     * @param $dateFrom string
     * @param $dateTo string
     * @return array
     * @throws CalendarException
     */
    public static function preparePeriodDates($dateFrom, $dateTo) {
        if (empty($dateFrom) && empty($dateTo)) {
            $dateFrom = (new \DateTime('now'));
            $dateTo = (new \DateTime( 'now' ))->modify('+ 1 month 1 day');
        } else {
            $dateFrom = \DateTime::createFromFormat('Y-m-d', $dateFrom);
            $dateTo = \DateTime::createFromFormat('Y-m-d', $dateTo)->modify('+ 1 day');
        }
        if ($dateTo < $dateFrom) {
            throw new CalendarException('Błędny zakres dat');
        }

        $periodDates = new \DatePeriod($dateFrom, new \DateInterval('P1D'), $dateTo);
        foreach ($periodDates as $periodDate) {
            $periodDatesArray[] = $periodDate;
        }
        
        return [
            'dateFrom'     => $dateFrom,
            'dateTo'       => $dateTo,
            'periodDates'  => $periodDates,
            'counterDates' => iterator_count($periodDates)
        ];
    }
    
    
    
}