import axios from "axios";
import React, { useEffect, useState } from "react";
import { useParams, useLocation } from 'react-router-dom';
import 'react-calendar/dist/Calendar.css';
import { differenceInCalendarDays, format } from 'date-fns';
import Button from '@mui/material/Button';

function isSameDay(a: Date|number, b: Date|number): boolean {
  return differenceInCalendarDays(a, b) === 0;
}

function ConvertResponse(yearMonthArray: string[]){
    return yearMonthArray.map((ym) => new Date(Number(ym.split('/')[0]), (Number(ym.split('/')[1]) - 1)));
}

type Schedule = {
    id: number;
    isOverNextDay: boolean;
    date: string;
    start: string;
    end: string;
  }

const ScheduleIndex: React.FC = () => {
  const { userId } = useParams();
  const params = new URLSearchParams(useLocation().search);
  const [schedules, setSchedules] = useState<Schedule[]>([]);

  useEffect(() => {
    console.log('Schedulesをリクエストします');
    console.log(params);
    axios
      .get(`/api/users/${userId}/attendances/schedules`, { params })
      .then(response => {
        console.log(response.data);
        setSchedules(response.data);
      })
      .catch(error => {
        console.log('Schedulesリクエストのエラーです');
        console.log(error);
        alert(error.response.data.message);
    });
  }, []);

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
        <ul className="task-list">
            { schedules.map(schedule => <li key={schedule.id}>{schedule.date}</li>) }
      </ul>
    </div>
  );
};

export default ScheduleIndex;
