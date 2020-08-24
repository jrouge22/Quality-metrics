import React from "react";
import  { MyList } from '../../MyList'
import {
	TextField,
	ReferenceManyField,
	SingleFieldList,
	ChipField,
	ShowButton
} from 'react-admin';

export const TechnoList = props => (
		<MyList {...props}>
			<TextField source="name" label="Nom" />
			<ReferenceManyField reference="versions" target="versions" label="Versions" sortable={false} >
				<SingleFieldList>
					<ChipField source="version" />
				</SingleFieldList>
			</ReferenceManyField>
			<ReferenceManyField reference="metrics" target="metrics" label="Métriques" sortable={false} >
				<SingleFieldList>
					<ChipField source="name" />
				</SingleFieldList>
			</ReferenceManyField>
		<ShowButton />
    </MyList>
);

export default TechnoList;
