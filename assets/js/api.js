export default class ApiCall {
	constructor(targetFile) {
		this.apiCall = targetFile;
	}

	async post(form) {
		return await fetch(
			`http://localhost:8080/e-commerce/controllers/${this.apiCall}`,
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