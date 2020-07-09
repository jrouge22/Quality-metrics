import React from "react";
import { HydraAdmin, fetchHydra, hydraDataProvider, ResourceGuesser } from "@api-platform/admin";
import { parseHydraDocumentation } from "@api-platform/api-doc-parser";
import { MetricList } from './metrics';
import { VersionList } from './versions';
import { TechnoList, TechnoShow } from './technos';
import { ProjectList, ProjectShow, ProjectCreate } from './projects';
import Dashboard from './dashboard';

// TODO : Recherche d'autres icones
import metricIcon from '@material-ui/icons/Poll';
import versionIcon from '@material-ui/icons/Work';
import technoIcon from '@material-ui/icons/Whatshot';
import projectIcon from '@material-ui/icons/Web';

const entrypoint = process.env.REACT_APP_API_ENTRYPOINT;

const dataProvider = hydraDataProvider(
    entrypoint,
    fetchHydra,
    parseHydraDocumentation,
    true
);

export default () => (
      <HydraAdmin
        dashboard={ Dashboard }
        dataProvider={ dataProvider }
        entrypoint={ entrypoint }
    >
        <ResourceGuesser name="metrics" list={MetricList} icon={metricIcon} />
        <ResourceGuesser name="technos" list={TechnoList} show={TechnoShow} icon={technoIcon} />
        <ResourceGuesser name="versions" list={VersionList} icon={versionIcon} />

        <ResourceGuesser name="projects" list={ProjectList} show={ProjectShow} create={ProjectCreate} icon={projectIcon} />
    </HydraAdmin>
);