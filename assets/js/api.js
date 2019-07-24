export default class ApiCall {
	const requestHeaders = new Headers({
		"Access-Control-Allow-Origin:" : "*"
	});
	constructor(targetFile) {
		this.apiCall = targetFile;
	}

	async post(form) {
		return await fetch(
			`https://e-z-shopping.000webhostapp.com/controllers/${this.apiCall}`,
			{
		    method: 'POST',
		    headers: requestHeaders,
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