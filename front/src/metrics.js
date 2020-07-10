import React from "react";
import { TextField, List, Datagrid } from 'react-admin';

export const MetricList = (props) => (
    <List {...props}>
        <Datagrid>
                <TextField source="name" label="Métrique" />
                <TextField source="levelOk" label="Palier minimum" />
                <TextField source="levelNice" label="Palier confort" />
        </Datagrid>
    </List>
);