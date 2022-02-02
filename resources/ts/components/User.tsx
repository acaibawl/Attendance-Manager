import axios from "axios";
import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom";
import { useParams } from 'react-router-dom';
import { Link } from 'react-router-dom';

type User = {
  id: number;
  name: string;
  email: string;
}


const User: React.FC = () => {

const { userId } = useParams();
const [user, setUser] = useState<User>({} as User);
  useEffect(() => {
    console.log('userをリクエストします');
    console.log(userId);
    axios
      .get(`/api/users/${userId}`)
      .then(response => {
        setUser(response.data);
      })
      .catch(error => {
        console.log('エラーです');
        console.log(error);
      });
  }, []);

  return (
    <div>
      <ul className="user-profile">
        <li>{user.id}</li>
        <li>{user.name}</li>
        <li>{user.email}</li>
        <li><Link to={'/users/' + userId + '/attendances/scheduleCalender'} >勤務予定</Link></li>
      </ul>
    </div>
  );
};

export default User;
