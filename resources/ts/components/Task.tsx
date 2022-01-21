import axios from "axios";
import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom";

type Task = {
  id: number;
  title: string;
}

const Task: React.FC = () => {

  const [tasks, setTasks] = useState<Task[]>([]);
  useEffect(() => {
    console.log('tasksをリクエストします');
    axios
      .get('/api/tasks')
      .then(response => {
        setTasks(response.data);
      })
      .catch(error => {
        console.log('エラーです');
        console.log(error);
      });
  }, []);
  
  return (
    <div>
      <ul className="task-list">
        { tasks.map(task => <li key={task.id}>{task.title}</li>) }
      </ul>
    </div>
  );
};

// if (document.getElementById('task')) {
//   ReactDOM.render(<Task />, document.getElementById('task'));
// }

export default Task;
