import { ApolloClient, InMemoryCache, createHttpLink, gql } from '@apollo/client';

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

const getActivity = (url, browseType, facet, values, callback) => {
  const client = getGraphQLClient(url, {});
  client
    .query({
      query: gql`
        query ($browseType: String, $facet: String, $values: [String!]) 
        { activity (browseType: $browseType, facet: $facet, values: $values) { key, created, item_count, items { id, title, identifier, detailUrl, viewerUrl, viewerClass, media {version, url, width, height, mimetype}, data {name, value} }, filters { facet, values { id, value } } } } `
      , variables: { 'browseType': browseType, 'facet': facet, 'values': values }
    })
    .then(function (result) {
      callback(result.data['activity']);
    }).catch(function (error) {
      console.log("Error while attempting to fetch activity: ", error);
    });
}

const getActivityList = (url, browseType, facet, callback) => {
  const client = getGraphQLClient(url, {});
  client
    .query({
      query: gql`
        query ($browseType: String, $facet: String) 
        { activityFacet (browseType: $browseType, facet: $facet) { name, type, values {
          id, value, displayData {
            name, value
          }
        } } } `
      , variables: { 'browseType': browseType, 'facet': facet }
    })
    .then(function (result) {
      callback(result.data['activityFacet']);
    }).catch(function (error) {
      console.log("Error while attempting to fetch activity list: ", error);
    });
}

export { getGraphQLClient, getActivity, getActivityList };