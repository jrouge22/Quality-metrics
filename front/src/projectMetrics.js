import React from "react";
import {
  Datagrid,
  TextField,
  DateField,
  ReferenceField,
  List
} from 'react-admin';

export const ProjectMetricsList = props => (
  <List {...props}>
    <Datagrid>
      <ReferenceField label="Projet" source="project" reference="projects">
        <TextField source="name" />
	  </ReferenceField>
      <ReferenceField label="Métrique" source="metric" reference="metrics">
        <TextField source="name" />
	  </ReferenceField>
      <TextField source="value" label="Valeur" />
      <TextField source="tag" label="Tag" />
      <TextField source="errorCode" label="Code erreur" />
      <DateField source="createdAt" locales="fr-FR" label="Date de création" />
    </Datagrid>
  </List>
);