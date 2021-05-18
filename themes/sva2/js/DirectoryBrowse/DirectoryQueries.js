import { ApolloClient, InMemoryCache, createHttpLink, gql } from '@apollo/client';
// import { setContext } from '@apollo/client/link/context';

// function getGraphQLClient(uri, options = null) {
//   const httpLink = createHttpLink({
//     uri: uri
//   });
//   const authLink = setContext((_, { headers }) => {
//     const token = pawtucketUIApps.Import.key;
//     return {
//       headers: {
//         ...headers,
//         authorization: token ? `Bearer ${token}` : "",
//       }
//     }
//   });
//   const client = new ApolloClient({
//     link: authLink.concat(httpLink),
//     cache: new InMemoryCache()
//   });
//   return client;
// }

function getGraphQLClient(uri, options = null) {
  const httpLink = createHttpLink({
    uri: uri
  });
  const client = new ApolloClient({
    link: httpLink,
    cache: new InMemoryCache()
  });
  return client;
}

const getBrowseBar = (url, browse, callback) => {
  const client = getGraphQLClient(url + '/Directory', {});
  client
    .query({
      query: gql`
        query($browse: String) { browseBar (browse: $browse) { displayTitle, values { value, display, disabled } } }`
      ,variables: { 'browse': browse }
    })
    .then(function (result) {
      callback(result.data['browseBar']);
    }).catch(function (error) {
      console.log("Error while attempting to fetch browseBar: ", error);
    });
}
const getBrowseContent = (url, browse, value, callback) => {
  const client = getGraphQLClient(url + '/Directory', {});
  client
    .query({
      query: gql`
        query($browse: String, $value: String) { browseContent (browse: $browse, value: $value) { values { value, display } } }`
      , variables: { 'browse': browse, 'value': value }
    })
    .then(function (result) {
      callback(result.data['browseContent']);
    }).catch(function (error) {
      console.log("Error while attempting to fetch browseContent: ", error);
    });
}

export { getGraphQLClient, getBrowseBar, getBrowseContent };