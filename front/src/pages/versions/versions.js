import React from "react";
import  { MyList } from '../../MyList'
import { TextField, BooleanField, DateField, ReferenceField } from 'react-admin';

export const VersionList = props => (
  <MyList {...props}>
		<ReferenceField source="techno" reference="technos" sortable={false} >
			<TextField source="name" label="Techno" />
		</ReferenceField>
		<TextField source="version" label="Version" />
		<BooleanField source="isLts" label="Long Term Support" />
		<DateField source="endSupport" locales="fr-FR" label="Fin de support" />
  </MyList>
);

export default VersionList;