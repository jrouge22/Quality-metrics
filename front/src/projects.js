import React from "react";
import {
	Datagrid,
	TextField,
	BooleanField,
	DateField,
	ReferenceManyField,
	SingleFieldList,
	ChipField,
	Show,
	Create,
	SimpleForm,
	TextInput,
	SelectInput,
	ReferenceInput,
	SimpleShowLayout,
	List,
	ShowButton
} from 'react-admin';

export const ProjectList = props => (
		<List {...props}>
				<Datagrid>
						<TextField source="name" label="Nom" />
						<TextField source="code" label="Code Projet" />
						<ReferenceManyField reference="versions" target="versions" label="Versions">
								<SingleFieldList>
										<ChipField source="version" />
								</SingleFieldList>
						</ReferenceManyField>
						<DateField source="createdAt" locales="fr-FR" label="Date de création" />
						<DateField source="updatedAt" locales="fr-FR" label="Fin de support" />
					<ShowButton />
				</Datagrid>
    </List>
);

const ProjectTitle = ({ record }) => {
    return <span>Projet {record ? `"${record.name}"` : ''}</span>;
};

export const ProjectShow = (props) => (
    <Show title={<ProjectTitle />} {...props}>
        <SimpleShowLayout>
            <TextField source="name" label="Nom" />
						<TextField source="code" label="Code Projet" />
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
						<ReferenceInput
								source="versions"
								reference="versions"
						>
						<SelectInput optionText="version" />
						</ReferenceInput>
				</SimpleForm>
		</Create>
);