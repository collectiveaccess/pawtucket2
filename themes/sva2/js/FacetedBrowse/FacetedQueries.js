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

const getFacets = (url, browseType, key, callback) => {
  const client = getGraphQLClient(url, {});
  client
    .query({
      query: gql`
        query ($browseType: String, $key: String) { facets (browseType: $browseType, key: $key) { key, facets { name, labelSingular, labelPlural, description, values { value, sortableValue, id }} } }`
      , variables: { 'browseType': browseType, 'key': key }
    })
    .then(function (result) {
      callback(result.data['facets']);
    }).catch(function (error) {
      console.log("Error while attempting to fetch facets: ", error);
    });
}

const getFacet = (url, browseType, key, facet, callback) => {
  const client = getGraphQLClient(url, {});
  client
    .query({
      query: gql`
        query ($browseType: String, $key: String, $facet: String) { facet (browseType: $browseType, key: $key, facet: $facet) { name, type, description, values { value, sortableValue, id } } }`
      , variables: { 'browseType': browseType, 'key': key, 'facet': facet }
    })
    .then(function (result) {
      callback(result.data['facet']);
    }).catch(function (error) {
      console.log("Error while attempting to fetch facet: ", error);
    });
}

const getResult = (url, browseType, key, start, limit, sort, callback) => {
  const client = getGraphQLClient(url, {});
  client
    .query({
      query: gql`
        query ($browseType: String, $key: String, $start: Int, $limit: Int, $sort: String) { result (browseType: $browseType, key: $key, start: $start, limit: $limit, sort: $sort) { key, created, item_count, content_type, content_type_display, items { id, title, detailUrl, identifier, media {version, url, width, height, mimetype} }, filters { facet, values { id, value } }, available_sorts {name, value} } }`
      , variables: { 'browseType': browseType, 'key': key, 'start': start, 'limit': limit, 'sort': sort }
      
    })
    .then(function (result) {
      callback(result.data['result']);
    }).catch(function (error) {
      console.log("Error while attempting to fetch result: ", error);
    });
}

const getFilters = (url, browseType, key, callback) => {
  const client = getGraphQLClient(url, {});
  client
    .query({
      query: gql`
        query ($browseType: String, $key: String) { filters (browseType: $browseType, key: $key) { key, filters { facet, values { id, value }} } }`
      , variables: { 'browseType': browseType, 'key': key }
    })
    .then(function (result) {
      callback(result.data['filters']);
    }).catch(function (error) {
      console.log("Error while attempting to fetch filters: ", error);
    });
}

function addFilterValue(uri, browseType, key, facet, values, callback) {
  const client = getGraphQLClient(uri, {});
  client
    .mutate({
      mutation: gql`
        mutation ($browseType: String!, $key: String!, $facet: String!, $values: [String!]) { addFilterValue(browseType: $browseType, key: $key, facet: $facet, values: $values) { key, created, item_count, items { id, title, identifier, media {version, url, width, height, mimetype} }, filters { facet, values { id, value } } } }
      `, variables: { 'browseType': browseType, 'key': key, 'facet': facet, 'values': values }
    })
    .then(function (result) {
      callback(result.data['addFilterValue']);
    }).catch(function (error) {
      console.log("Error while attempting to addFilterValue: ", error);
    });
}

function removeFilterValue(uri, browseType, key, facet, value, callback) {
  const client = getGraphQLClient(uri, {});
  client
    .mutate({
      mutation: gql`
        mutation ($browseType: String!, $key: String!, $facet: String!, $value: String) { removeFilterValue(browseType: $browseType, key: $key, facet: $facet, value: $value) { key, created, item_count, items { id, title, identifier }, filters { facet, values { id, value } } } }
      `, variables: { 'browseType': browseType, 'key': key, 'facet': facet, 'value': value }
    })
    .then(function (result) {
      callback(result.data['removeFilterValue']);
    }).catch(function (error) {
      console.log("Error while attempting to removeFilterValue: ", error);
    });
}

function removeAllFilterValues(uri, browseType, key, callback) {
  const client = getGraphQLClient(uri, {});
  client
    .mutate({
      mutation: gql`
        mutation ($browseType: String!, $key: String!) { removeAllFilterValues(browseType: $browseType, key: $key) { key, created, item_count, items { id, title, identifier }, filters { facet, values { id, value } } } }
      `, variables: { 'browseType': browseType, 'key': key }
    })
    .then(function (result) {
      callback(result.data['removeAllFilterValues']);
    }).catch(function (error) {
      console.log("Error while attempting to removeAllFilterValues: ", error);
    });
}

export { getGraphQLClient, getFacets, getFacet, getResult, getFilters, addFilterValue, removeFilterValue, removeAllFilterValues };