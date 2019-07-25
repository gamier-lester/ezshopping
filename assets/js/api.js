import config from '../../config/config.js';
export default class ApiCall {
	constructor(targetFile) {
		this.apiCall = targetFile;
		this.urlPath = config.production ? config.projectApi.production : config.projectApi.development;
	}

	async post(form) {
		return await fetch(
			`${this.urlPath}/controllers/${this.apiCall}`,
			{
		    method: 'POST',
				body: form
	  }).then(function(response) {
	    if (response.status >= 200 && response.status < 300) {
        return response.json()
	    }
	    throw new Error(response.statusText)
	  }).then(function(response) {
	  	return response;
		});
	}
}