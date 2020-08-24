import React from "react";
import { List, Datagrid } from 'react-admin';

export const MyList = ({ children, ...props}) => (
  <List {...props}>
    <Datagrid>
    	{children}
    </Datagrid>
  </List>
);
