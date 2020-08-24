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

import metrics from './pages/metrics';
import projectMetrics from './pages/projectMetrics';
import projects from './pages/projects';
import technos from './pages/technos';
import versions from './pages/versions';

import Dashboard from './pages/dashboard';
import CustomLayout from './layouts/customLayout';

import customRoutes from './customRoutes';

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
    dashboard={Dashboard}
    dataProvider={dataProvider}
    entrypoint={entrypoint}
    authProvider={authProvider}
  >
    <ResourceGuesser name="metrics" {...metrics} />
    <ResourceGuesser name="technos" {...technos} />
    <ResourceGuesser name="versions" {...versions} />
    <ResourceGuesser name="projects" {...projects} />
    <ResourceGuesser name="project_metrics" {...projectMetrics} />

    <ResourceGuesser name="show_metrics_projects" />
  </HydraAdmin>
);