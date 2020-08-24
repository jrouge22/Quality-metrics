import React from "react";
import { TextField } from 'react-admin';
import { MyList } from '../../MyList'

export const MetricList = props => (
  <MyList {...props}>
    <TextField source="name" label="Métrique" />
    <TextField source="levelOk" label="Palier minimum" sortable={false} />
    <TextField source="levelNice" label="Palier confort" sortable={false} />
  </MyList>
);

export default MetricList;
