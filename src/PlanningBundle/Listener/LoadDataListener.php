<?php


namespace PlanningBundle\Listener;


use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
use AncaRebeca\FullCalendarBundle\Model\FullCalendarEvent;
use PlanningBundle\Entity\Main\CalendarEvents as MyCustomEvent;

class LoadDataListener
{
    /**
     * @param CalendarEvent $calendarEvent
     *
     * @return FullCalendarEvent[]
     */
    public function loadData(CalendarEvent $calendarEvent)
    {
        $startDate = $calendarEvent->getStart();
        $endDate = $calendarEvent->getEnd();
        $filters = $calendarEvent->getFilters();

        //You may want do a custom query to populate the events

        $calendarEvent->addEvent(new MyCustomEvent('Event Title 1', new \DateTime()));
//        $calendarEvent->addEvent(new MyCustomEvent('Event Title 2', new \DateTime()));


    }
}