import { ApolloClient, InMemoryCache, createHttpLink, gql } from '@apollo/client';
import { setContext } from '@apollo/client/link/context';

function getGraphQLClient(uri, options = null) {
  const httpLink = createHttpLink({
    uri: uri
  });
  const authLink = setContext((_, { headers }) => {
    const token = pawtucketUIApps.Comment.key;
    return {
      headers: {
        ...headers,
        authorization: token ? `Bearer ${token}` : "",
      }
    }
  });
  const client = new ApolloClient({
    link: authLink.concat(httpLink),
    cache: new InMemoryCache()
  });
  return client;
}

const getContent = (url, table, id, callback) => {
  const client = getGraphQLClient(url, {});
  client
    .query({
      query: gql`
        query ($table: String, $id: Int) { 
          content (table: $table, id: $id) { 
            comments { comment, author, email, date, duration }, tags { tag }
        } }`

      , variables: { 'table': table, 'id': id }
    })
    .then(function (result) {
      callback(result.data['content']);
    }).catch(function (error) {
      console.log("Error while attempting to getContent: ", error);
    });
}


function addComment(uri, table, id, comment, callback) {
  const client = getGraphQLClient(uri, {});
  client
  .mutate({
    mutation: gql`
    mutation ($table: String, $id: Int, $comment: String) { 
      addComment(table: $table, id: $id, comment: $comment) {
        message, error, commentsAdded, tagsAdded, emailSent
      } }`
      , variables: { 'table': table, 'id': id, 'comment': comment}
    })
    .then(function (result) {
      callback(result.data['addComment']);
    }).catch(function (error) {
      console.log("Error while attempting to addComment: ", error);
    });
}
  
function addTag(uri, table, id, tags, callback) {
  const client = getGraphQLClient(uri, {});
  client
  .mutate({
    mutation: gql`
    mutation ($table: String, $id: Int, $tags: [String]) { 
      addTags(table: $table, id: $id, tags: $tags) {
        message, error, commentsAdded, tagsAdded, emailSent
      } }`
      , variables: { 'table': table, 'id': id, 'tags': tags }
    })
    .then(function (result) {
      callback(result.data['addTags']);
    }).catch(function (error) {
      console.log("Error while attempting to addTag: ", error);
    });
}
    
const suggestTags = (url, table, id, text, callback) => {
  const client = getGraphQLClient(url, {});
  client
    .query({
      query: gql`
        query ($table: String, $id: Int, $text: String) { 
          suggestTags(table: $table, id: $id, text: $text) { 
            tags
        } }`

      , variables: {'table': table, 'id': id, 'text': text }
    })
    .then(function (result) {
      callback(result.data['suggestTags']);
    }).catch(function (error) {
      console.log("Error while attempting to suggestTags: ", error);
    });
}

  export { getGraphQLClient, getContent, addComment, addTag, suggestTags };