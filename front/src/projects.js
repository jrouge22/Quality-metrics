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
  ShowButton,
  EditButton
} from 'react-admin';

export const ProjectList = props => (
  <List {...props}>
    <Datagrid>
      <TextField source="name" label="Nom" />
      <TextField source="code" label="Code Projet" />
      <ReferenceArrayField reference="versions" source="version" label="Versions" sortable={false} >
        <SingleFieldList>
          <ChipField source="technoVersionName" />
        </SingleFieldList>
      </ReferenceArrayField>
      <DateField source="createdAt" locales="fr-FR" label="Date de création" />
      <DateField source="updatedAt" locales="fr-FR" label="Fin de support" />
      <EditButton />
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
          <ReferenceField label="Métrique" source="metric" reference="metrics">
            <TextField source="name" />
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
        source="version"
        reference="versions"
        label="Technos / Versions"
      >
        <SelectArrayInput optionText="technoVersionName" />
      </ReferenceArrayInput>
    </SimpleForm>
  </Create>
);