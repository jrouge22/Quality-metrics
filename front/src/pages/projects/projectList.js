import React from "react";
import  { MyList } from '../../MyList'
import {
  TextField,
  DateField,
  ReferenceArrayField,
  SingleFieldList,
  ChipField,
  ShowButton,
  EditButton
} from 'react-admin';

export const ProjectList = props => (
  <MyList {...props}>
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
  </MyList>
);

export default ProjectList;