import React from "react";
import {
  Create,
  SimpleForm,
  TextInput,
  SelectArrayInput,
  ReferenceArrayInput
} from 'react-admin';

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

export default ProjectCreate;
