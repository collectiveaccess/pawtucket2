import { ApolloClient, InMemoryCache, createHttpLink, gql, from } from '@apollo/client';
import { setContext } from '@apollo/client/link/context';
import { onError } from "@apollo/client/link/error";



function getGraphQLClient(uri, tokens, options=null) {
	const errorLink = onError(({ graphQLErrors, networkError }) => {
	  if (graphQLErrors)
		graphQLErrors.forEach(({ message, locations, path }) =>
		  console.log(
			`[GraphQL error]: Message: ${message}, Location: ${locations}, Path: ${path}`
		  )
		);
	  if (networkError) console.log(`[Network error]: ${networkError}`);
	});
	const httpLink = createHttpLink({
	  uri: uri,
	});
	
	if(!options) { options = {}; }
	
	let use_token = options['refresh'] ? tokens.refresh_token : tokens.access_token;
	console.log("apollo client use token", use_token);

	const authLink = setContext((_, { headers }) => {
	  // return the headers to the context so httpLink can read them
	  return {
		headers: {
		  ...headers,
		  authorization: tokens.refresh_token ? `Bearer ${use_token}` : "",
		}
	  }
	});
	const client = new ApolloClient({
	  link: from([errorLink, authLink.concat(httpLink)]),
	  cache: new InMemoryCache()
	});
	
	return client;
}

const fetchWithRefresh = (uri, refresh_token, options) => {
	this.refreshingPromise = null;

	var initialRequest = fetch(uri, options);

	return initialRequest.then((response) => {
		return(response.json());
	}).then((json) => {
		if (json && json.errors && json.errors[0] && json.errors[0].message === 'User is not logged in.') {
			// 401 error = expired token
			if (!this.refreshingPromise) {
				// Create the address to grab a new token from
				// This endpoint may vary based on your Oauth server
				var address = Config.REACT_APP_SERVER_ADDRESS+'/o/token/?grant_type=refresh_token&refresh_token='+refresh_token+'&client_id='+client_id

				// Execute the re-authorization request and set the promise returned to this.refreshingPromise
				this.refreshingPromise = fetch(address, { method: 'POST' })
					.then((refresh_token_repsonse) => {
						if(refresh_token_repsonse.ok){
							return refresh_token_repsonse.json().then((refreshJSON) => {
								// Refresh succeeded
								// Save the new refresh token to your store or wherever you are keeping it
								// saveRefreshToken(refreshJSON.refresh_token)

								// Return the new access token as a result of the promise
								return refreshJSON.access_token
							})
						}else{
							// Refresh failed
						}
				})
			}
			return this.refreshingPromise.then((newAccessToken) => {
				// Now that the refreshing promise has been executed, set it to null
				this.refreshingPromise = null;

				// Set the authorization header on the original options parameter to the new access token we got
				options.headers.authorization = `Bearer ${newAccessToken}`

				// Return the promise from the new fetch (which should now have used an active access token)
				// If the initialRequest had errors, this fetch that is returned below is the final result.
				return fetch(uri, options);
			})
		}

		// If there were no errors in the initialRequest, we need to repackage the promise and return it as the final result.
		var result = {};
		result.ok = true;
		result.json = () => new Promise(function(resolve, reject) {
			resolve(json);
		});
		return result;
	});
}

export { getGraphQLClient};