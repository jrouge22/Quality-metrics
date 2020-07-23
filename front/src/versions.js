import React from "react";
import { TextField, BooleanField, DateField, ReferenceField, List, Datagrid } from 'react-admin';

export const VersionList = props => (
    <List {...props}>
				<Datagrid>
						<ReferenceField source="techno" reference="technos" sortable={false} >
								<TextField source="name" label="Techno" />
						</ReferenceField>
						<TextField source="version" label="Version" />
						<BooleanField source="isLts" label="Long Term Support" />
						<DateField source="endSupport" locales="fr-FR" label="Fin de support" />
				</Datagrid>
    </List>
);