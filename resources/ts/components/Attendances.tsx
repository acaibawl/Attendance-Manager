import axios from "axios";
import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom";
import { useParams } from 'react-router-dom';

type Attendance = {
  id: number;
  title: string;
}

const Attendances: React.FC = () => {
  const { id } = useParams();

  const [Attendances, setAttendances] = useState<Attendance[]>([]);
  useEffect(() => {
    console.log('attendancesをリクエストします');
    axios
      .get(`/api/users/${id}/attendances`)
      .then(response => {
        setAttendances(response.data);
      })
      .catch(error => {
        console.log('エラーです');
        console.log(error);
      });
  }, []);

  return (
    <div>
      <ul className="Attendance-list">
        { Attendances.map(Attendance => <li key={Attendance.id}>{Attendance.title}</li>) }
      </ul>
    </div>
  );
};

export default Attendances;
