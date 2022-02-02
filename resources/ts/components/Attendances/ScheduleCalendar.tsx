import axios from "axios";
import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom";
import { useParams } from 'react-router-dom';
import Calendar, { CalendarTileProperties } from 'react-calendar';
import 'react-calendar/dist/Calendar.css';
import { differenceInCalendarDays, format } from 'date-fns';
import { Link } from 'react-router-dom';

function isSameDay(a: Date|number, b: Date|number): boolean {
  return differenceInCalendarDays(a, b) === 0;
}

function ConvertResponse(yearMonthArray: string[]){
    return yearMonthArray.map((ym) => new Date(Number(ym.split('/')[0]), (Number(ym.split('/')[1]) - 1)));
}

const ScheduleCalendar: React.FC = () => {
  const { userId } = useParams();

  const [scheduleMonths, setScheduleMonths] = useState<Date[]>([]);
  useEffect(() => {
    console.log('Schedulesをリクエストします');
    axios
      .get(`/api/users/${userId}/attendances/monthsHasSchedule`)
      .then(response => {
        setScheduleMonths(ConvertResponse(response.data));
      })
      .catch(error => {
        console.log('エラーです');
        console.log(error);
      });
  }, []);

  const tileDisabled = (props: CalendarTileProperties): boolean => {
    // Disable tiles in year view only
      if (props.view === 'year') {
        // Check if a date React-Calendar wants to check is on the list of disabled dates
        const result = scheduleMonths.find(dDate => isSameDay(dDate, props.date));
        if(result === undefined) return true;
        return false;
      } else {
        return false;
      }
    };

  const initialDate = new Date();
  const [startDate, setStartDate] = useState(initialDate);
  const handleChange = (date: Date) => {
    setStartDate(date);
  }

  return (
    <div>
      <Calendar
        onChange={handleChange}
        value={startDate}
        defaultView="year"
        maxDetail="year"
        minDetail="decade"
        tileDisabled={tileDisabled}
      />
    <Link to={`users/${userId}/attendances/schedules/${format(startDate, 'yyyyMM')}`}>勤務予定</Link>
    </div>
  );
};

export default ScheduleCalendar;
