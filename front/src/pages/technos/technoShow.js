import React from "react";
import {
	Datagrid,
	TextField,
	BooleanField,
	DateField,
	ReferenceManyField,
	Show,
	SimpleShowLayout
} from 'react-admin';

const TechnoTitle = ({ record }) => {
    return <span>Techno {record ? `"${record.name}"` : ''}</span>;
};

export const TechnoShow = (props) => (
  <Show title={<TechnoTitle />} {...props}>
    <SimpleShowLayout>
      <TextField source="id" />
      <TextField source="name" label="Nom" />
			<ReferenceManyField
				reference="versions"
				target="versions"
				label="Versions"
			>
				<Datagrid>
					<TextField source="version" label="Version" />
					<BooleanField source="isLts" label="Long Term Support" />
					<DateField source="endSupport" locales="fr-FR" label="Fin de support" />
				</Datagrid>
			</ReferenceManyField>
			<ReferenceManyField
				reference="metrics"
				target="metrics"
				label="Métriques"
			>
				<Datagrid>
					<TextField source="name" label="Métrique" />
					<TextField source="levelOk" label="Palier minimum" />
					<TextField source="levelNice" label="Palier confort" />
				</Datagrid>
			</ReferenceManyField>
    </SimpleShowLayout>
  </Show>
);

export default TechnoShow;
