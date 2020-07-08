import React from "react";
import {
	Datagrid,
	TextField,
	BooleanField,
	DateField,
	ReferenceField,
	ReferenceManyField,
	SingleFieldList,
	ChipField,
	Show,
	SimpleShowLayout,
	List,
	ShowButton
} from 'react-admin';

export const TechnoList = props => (
		<List {...props}>
				<Datagrid>
						<TextField source="name" label="Nom" />
						<ReferenceManyField reference="versions" target="versions" sortBy="versions.versions" label="Versions">
								<SingleFieldList>
										<ChipField source="version" />
								</SingleFieldList>
						</ReferenceManyField>
						<ReferenceManyField reference="metrics" target="metrics" label="Métriques">
								<SingleFieldList>
										<ChipField source="name" />
								</SingleFieldList>
						</ReferenceManyField>
					<ShowButton />
				</Datagrid>
    </List>
);

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