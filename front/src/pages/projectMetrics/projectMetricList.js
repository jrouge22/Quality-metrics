import React from "react";
import  { MyList } from '../../MyList'
import {
  TextField,
  DateField,
  ReferenceField
} from 'react-admin';

export const ProjectMetricList = props => (
  <MyList {...props}>
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
  </MyList>
);

export default ProjectMetricList;
