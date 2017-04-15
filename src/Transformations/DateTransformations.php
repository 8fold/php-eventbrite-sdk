<?php

namespace Eightfold\Eventbrite\Transformations;

use Carbon\Carbon;

trait DateTransformations
{
   private $startDate = null;

    private $endDate = null;

    public function getStartDateString()
    {
        $startDate = $this->getStartDate();
        return $this->getDateString($startDate);
    }

    public function getEndDateString()
    {
        $endDate = $this->getEndDate();
        return $this->getDateString($endDate);
    }

    public function getStartTimeString()
    {
        $startDate = $this->getStartDate();
        return $this->getTimeString($startDate);
    }

    public function getEndTimeString()
    {
        $endDate = $this->getEndDate();
        return $this->getTimeString($endDate);
    }

    public function getTimezoneString()
    {
        return $this->startDate->format('T');
    }

    private function getDateString($date)
    {
        return $date->toFormattedDateString();
    }

    private function getTimeString($date)
    {
        return $date->format('g:i a');   
    }

    private function getStartDate()
    {
        if (is_null($this->startDate)) {
            $this->startDate = $this->getDate($this->start['utc'], $this->start['timezone']);
        }
        return $this->startDate;
    }

    private function getEndDate()
    {
        if (is_null($this->endDate)) {
            $this->endDate = $this->getDate($this->end['local'], $this->end['timezone']);
        }
        return $this->endDate;
    }

    private function getDate($date, $tz)
    {
        $date = new Carbon($date);
        $date->timezone = $tz;
        return $date;
    }
}