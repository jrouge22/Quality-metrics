import * as React from "react";
import Card from '@material-ui/core/Card';
import CardContent from '@material-ui/core/CardContent';
import { Title } from 'react-admin';

const entrypoint = process.env.REACT_APP_API_ENTRYPOINT;
const urlPMShow = entrypoint + '/show_metrics_projects';

const toto = () => {
	return fetch(urlPMShow)
	.then(res => res.json())
	.then(
		(result) => {
			console.log(result);
		  this.setState({
		    isLoaded: true,
		    items: result.items
		  });
		},
		// Remarque : il est important de traiter les erreurs ici
		// au lieu d'utiliser un bloc catch(), pour ne pas passer à la trappe
		// des exceptions provenant de réels bugs du composant.
		(error) => {
		  this.setState({
		    isLoaded: true,
		    error
		  });
		}
	)
}

const ProjectMetricsShow = () => (
    <Card>
        <Title title={toto} />
        <CardContent>
            ...
        </CardContent>
    </Card>
);

export default ProjectMetricsShow;
