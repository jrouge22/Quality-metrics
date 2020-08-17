import * as React from "react";
import { Route } from 'react-router-dom';
import ProjectMetricsShow from './projectMetricsShow';

export default [
    <Route exact path="/show_metrics_projects" component={ProjectMetricsShow} />
];