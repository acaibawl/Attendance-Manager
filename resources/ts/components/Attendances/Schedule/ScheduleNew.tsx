import axios from "axios";
import React, { useEffect, useState } from "react";
import { useParams } from 'react-router-dom';
import Calendar, { CalendarTileProperties } from 'react-calendar';
import 'react-calendar/dist/Calendar.css';
import { differenceInCalendarDays, format } from 'date-fns';
import Button from '@mui/material/Button';

function isSameDay(a: Date|number, b: Date|number): boolean {
  return differenceInCalendarDays(a, b) === 0;
}

function ConvertResponse(yearMonthArray: string[]){
    return yearMonthArray.map((ym) => new Date(Number(ym.split('/')[0]), (Number(ym.split('/')[1]) - 1)));
}

const ScheduleNew: React.FC = () => {
  const { userId } = useParams();

  const [scheduleMonths, setScheduleMonths] = useState<Date[]>([]);
  useEffect(() => {
    console.log('Schedulesをリクエストします');
    axios
      .get(`/api/users/${userId}/attendances/schedules`)
      .then(response => {
        console.log(response.data);
        setScheduleMonths(ConvertResponse(response.data));
      })
      .catch(error => {
        console.log('Schedulesリクエストのエラーです');
        console.log(error);
      });
  }, []);

  const tileDisabled = (props: CalendarTileProperties): boolean => {
    // Disable tiles in year view only
      if (props.view === 'year') {
        // Check if a date React-Calendar wants to check is on the list of disabled dates
        const result = scheduleMonths.find(dDate => isSameDay(dDate, props.date));
        if(result === undefined) return false;
        return true;
      } else {
        return false;
      }
    };

  const initialDate = new Date();
  const [stateDate, setStateDate] = useState<Date>(initialDate);
  const handleChange = (date: Date) => {
    setStateDate(date);
  }

  const handlePost = () => {
    axios
    .post(`/api/users/${userId}/attendances/schedules`, { date: stateDate})
    .then(response => {
        console.log(`${response.data}`);
        alert("スケジュールを作成しました");
    })
    .catch(error => {
        // HTTPステータスコード400番台がcatch、500はthenに入る
        console.log(error.response.data);
        alert(error.response.data.message);
    });
  }

  return (
    <div>
      <Calendar
        onChange={handleChange}
        value={stateDate}
        defaultView="year"
        maxDetail="year"
        minDetail="decade"
        tileDisabled={tileDisabled}
      />
    <Button type="button" variant="contained" color="primary" onClick={handlePost} >スケジュール作成</Button>
    </div>
  );
};

export default ScheduleNew;
