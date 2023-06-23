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

const getResult = (url, browseType, key, start, limit, callback) => {
  const client = getGraphQLClient(url, {});
  client
    .query({
      query: gql`
        query ($browseType: String, $key: String, $start: Int, $limit: Int) { result (browseType: $browseType, key: $key, start: $start, limit: $limit) { key, created, item_count, items { id, title, detailUrl, identifier, media {version, url, width, height, mimetype} }, filters { facet, values { id, value } } } }`
      , variables: { 'browseType': browseType, 'key': key, 'start': start, 'limit': limit }
    })
    .then(function (result) {
      callback(result.data['result']);
    }).catch(function (error) {
      console.log("Error while attempting to fetch result: ", error);
    });
}

const getFacet = (url, browseType, key, facet, callback) => {
  const client = getGraphQLClient(url, {});
  client
    .query({
      query: gql
      `query ($browseType: String, $key: String, $facet: String) { facet (browseType: $browseType, key: $key, facet: $facet)
          { name, type, description, values { id, value, sortableValue, displayData {name, value} } } }`
      , variables: { 'browseType': browseType, 'key': key, 'facet': facet }
    })
    .then(function (result) {
      callback(result.data['facet']);
    }).catch(function (error) {
      console.log("Error while attempting to fetch facet: ", error);
    });
}

function addFilterValue(uri, browseType, key, facet, values, sort, callback) {
  const client = getGraphQLClient(uri, {});
  client
    .mutate({
      mutation: gql`
        mutation ($browseType: String!, $key: String!, $facet: String!, $values: [String!], $sort: String) { addFilterValue(browseType: $browseType, key: $key, facet: $facet, values: $values, sort: $sort) { key, created, item_count, items { id, title, identifier, detailUrl, media {version, url, width, height, mimetype}, data { name, value } }, filters { facet, values { id, value } } } }
      `, variables: { 'browseType': browseType, 'key': key, 'facet': facet, 'values': values, 'sort': sort }
    })
    .then(function (result) {
      callback(result.data['addFilterValue']);
    }).catch(function (error) {
      console.log("Error while attempting to addFilterValue: ", error);
    });
}

export { getGraphQLClient, getResult, addFilterValue, getFacet };