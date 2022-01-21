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

export default Project;
