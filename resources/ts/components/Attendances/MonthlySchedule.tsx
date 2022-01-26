import axios from "axios";
import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom";
import { useParams } from 'react-router-dom';

type Schedule = {
  id: number;
  is_over_next_day: string;
  date: Date;
  start: Date;
  end: Date;
}

const MonthlySchedule: React.FC = () => {
  const { userId } = useParams();

  const [Schedules, setSchedules] = useState<Schedule[]>([]);
  useEffect(() => {
    console.log('Schedulesをリクエストします');
    axios
      .get(`/api/users/${userId}/attendances/schedules`)
      .then(response => {
        setSchedules(response.data);
      })
      .catch(error => {
        console.log('エラーです');
        console.log(error);
      });
  }, []);
  
  return (
    <div>
        { Schedules.map(Schedule => 
          <ul className="Schedule-list" key={Schedule.id} >
             <li >{Schedule.is_over_next_day}</li> 
             <li >{Schedule.date}</li> 
             <li >{Schedule.start}</li> 
             <li >{Schedule.end}</li> 
          </ul>) }
    </div>
  );
};

export default MonthlySchedule;
