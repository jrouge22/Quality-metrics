import React from "react";
import { Redirect, Route } from "react-router-dom";
import { parseHydraDocumentation } from "@api-platform/api-doc-parser";
import {
  HydraAdmin,
  ResourceGuesser,
  hydraDataProvider as baseHydraDataProvider,
  fetchHydra as baseFetchHydra
} from "@api-platform/admin";
import authProvider from './authProvider';
import { MetricList } from './metrics';
import { VersionList } from './versions';
import { TechnoList, TechnoShow } from './technos';
import { ProjectList, ProjectShow, ProjectCreate } from './projects';
import { ProjectMetricsList } from './projectMetrics';
import Dashboard from './dashboard';
import CustomLayout from './customLayout';

import customRoutes from './customRoutes';

// TODO : Recherche d'autres icones
import metricIcon from '@material-ui/icons/Poll';
import versionIcon from '@material-ui/icons/Work';
import technoIcon from '@material-ui/icons/Whatshot';
import projectIcon from '@material-ui/icons/Web';

const entrypoint = process.env.REACT_APP_API_ENTRYPOINT;
const fetchHeaders = { Authorization: `Bearer ${localStorage.getItem('token')}` };
const fetchHydra = (url, options = {}) => baseFetchHydra(url, {
  ...options,
  headers: new Headers(fetchHeaders),
});

const apiDocumentationParser = entrypoint => parseHydraDocumentation(entrypoint, { headers: new Headers(fetchHeaders) })
  .then(
    ({ api }) => ({ api }),
    (result) => {
      switch (result.status) {
        case 401:
          localStorage.removeItem('token');
          return Promise.resolve({
            api: result.api,
            customRoutes: [
              <Route path="/" render={() => {
                  return localStorage.getItem('token') ? window.location.reload() : <Redirect to="/login" />
                }
              } />
            ],
          });
        default:
          return Promise.reject(result);
      }
    },
  );
const dataProvider = baseHydraDataProvider(entrypoint, fetchHydra, apiDocumentationParser);

export default () => (
  <HydraAdmin
    layout={CustomLayout}
    customRoutes={customRoutes}
    dashboard={ Dashboard }
    dataProvider={ dataProvider }
    entrypoint={ entrypoint }
    authProvider={authProvider}
  >
    <ResourceGuesser name="metrics" list={MetricList} icon={metricIcon} />
    <ResourceGuesser name="technos" list={TechnoList} show={TechnoShow} icon={technoIcon} />
    <ResourceGuesser name="versions" list={VersionList} icon={versionIcon} />

    <ResourceGuesser name="projects" list={ProjectList} show={ProjectShow} create={ProjectCreate} icon={projectIcon} />

    <ResourceGuesser name="project_metrics" list={ProjectMetricsList} />
  </HydraAdmin>
);
