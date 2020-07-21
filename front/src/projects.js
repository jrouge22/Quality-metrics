import React from "react";
import {
	Datagrid,
	TextField,
	BooleanField,
	DateField,
	ReferenceField,
	ReferenceArrayField,
	SingleFieldList,
	ChipField,
	Show,
	Create,
	SimpleForm,
	TextInput,
	SelectArrayInput,
	ReferenceArrayInput,
	SimpleShowLayout,
	List,
	ShowButton
} from 'react-admin';

export const ProjectList = props => (
		<List {...props}>
				<Datagrid>
						<TextField source="name" label="Nom" />
						<TextField source="code" label="Code Projet" />
						<ReferenceArrayField reference="versions" source="version" label="Versions" >
								<SingleFieldList>
										<ChipField source="version" />
								</SingleFieldList>
						</ReferenceArrayField>
						<DateField source="createdAt" locales="fr-FR" label="Date de création" />
						<DateField source="updatedAt" locales="fr-FR" label="Fin de support" />
					<ShowButton />
				</Datagrid>
    </List>
);

const ProjectTitle = ({ record }) => {
    return <span>Projet {record ? `"${record.name}"` : ''}</span>;
};

const optionRenderer = version => {
	return `toto : ${version.techno} ${version.version}`;
}

export const ProjectShow = (props) => (
    <Show title={<ProjectTitle />} {...props}>
        <SimpleShowLayout>
            <TextField source="name" label="Nom" />
						<TextField source="code" label="Code Projet" />
						<ReferenceArrayField
								reference="versions"
								source="version"
								label="Versions"
						>
								<Datagrid>
										<TextField source="version" label="Version" />
										<BooleanField source="isLts" label="Long Term Support" />
										<DateField source="endSupport" locales="fr-FR" label="Fin de support" />
								</Datagrid>
						</ReferenceArrayField>
						<ReferenceArrayField
								reference="project_metrics"
								source="projectMetrics"
								label="Métriques"
						>
								<Datagrid>
										<ReferenceField reference="metrics" source="projectMetric.metric" label="Versions">
												<SingleFieldList>
														<ChipField source="name" label="Métrique" />
												</SingleFieldList>
										</ReferenceField>
										<TextField source="value" label="Valeur" />
										<TextField source="tag" label="Tag" />
								</Datagrid>
						</ReferenceArrayField>
						<DateField source="createdAt" locales="fr-FR" label="Date de création" />
						<DateField source="updatedAt" locales="fr-FR" label="Fin de support" />
        </SimpleShowLayout>
    </Show>
);


export const ProjectCreate = (props) => (
		<Create {...props}>
				<SimpleForm redirect="show">
						<TextInput source="name" label="Nom" />
						<TextInput source="code" label="Code Projet" />
						<ReferenceArrayInput
							source="versions"
							reference="versions"
							label="Technos / Versions"
						>
							<SelectArrayInput optionText={optionRenderer} />
						</ReferenceArrayInput>
				</SimpleForm>
		</Create>
);