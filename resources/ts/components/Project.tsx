import React, { ReactNode, FC } from "react";
import ReactDOM from "react-dom";

type NoneProps = {children?: never}

const Project: FC<NoneProps> = () => {
  return (
    <div>
      <p>プロジェクトコンポーネント</p>
    </div>
  );
};

if (document.getElementById('project')) {
  ReactDOM.render(<Project />, document.getElementById('project'));
}

export default Project;


