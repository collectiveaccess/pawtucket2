import { ApolloClient, InMemoryCache, createHttpLink, gql } from '@apollo/client';
import { setContext } from '@apollo/client/link/context';

function getGraphQLClient(uri, options = null) {
  const httpLink = createHttpLink({
    uri: uri
  });
  const authLink = setContext((_, { headers }) => {
    const token = pawtucketUIApps.Import.key;
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

/* Returns the list of sessions, both in_progress and submitted  */
const getSessionList = (url, callback) => {
  const client = getGraphQLClient(url + '/Importer', {});
  client
    .query({
      query: gql`
        query { sessionList { sessions { label, sessionKey, user_id, username, email, status, statusDisplay, createdOn, lastActivityOn, source, files, totalSize, totalBytes, receivedSize, receivedBytes }}}`
    })
    .then(function (result) {
      // console.log('sessionList result: ', result.data.sessionList.sessions);
      callback(result.data['sessionList']);
    }).catch(function (error) {
      console.log("Error while attempting to fetch sessionList: ", error);
    });
}

/* Delete an import session */
const deleteImport = (url, sessKey, callback) => {
  const client = getGraphQLClient(url + '/Importer', {});
  // let sessKey = props.data.sessionKey;
  client
    .query({
      query: gql`
    query($sessionKey: String!) { deleteSession (sessionKey: $sessionKey) { deleted }}`, variables: { 'sessionKey': sessKey }
    })
    .then(function (result) {
      // console.log('delete result: ', result.data);
      callback(result.data['deleteSession']);
    }).catch(function (error) {
      console.log("Error while attempting to delete import ", error);
    });
}

/* Create a new import session */
const getNewSession = (url, formCode, callback) => {
  const client = getGraphQLClient(url + '/Importer', {});
  client
    .query({
      query: gql`
        query ($code: String!){ newSession (code: $code){ sessionKey, defaults }}`, variables: {'code': formCode }
    })
    .then(function (result) { 
      if(callback) { callback(result.data['newSession']); }
    }).catch(function (error) {
      console.log("Error while attempting to create newSession: ", error);
    });
}

/* Return list of forms */
const getFormList = (url, callback) => {
  const client = getGraphQLClient(url + '/Importer', {});
  client
    .query({
      query: gql` query { formList { forms { code, title, table} }} `
    })
    .then(function (result) {
      // console.log('list result: ', result.data.formList.forms[0].code);
      callback(result.data['formList']);
    }).catch(function (error) {
      console.log("Error while attempting to fetch list code: ", error);
    });
}

const getForm = (url, formCode, callback) => {
  const client = getGraphQLClient(url + '/Importer', {});
  
    client
      .query({
        query: gql` query ($code: String!) { form (code: $code) { title, type, description, properties, uiSchema, required } } `, variables: { 'code': formCode }
      })
      .then(function (result) {
        // console.log('form result: ', result.data.form);
        callback(result.data['form']);
      }).catch(function (error) {
        console.log("Error while attempting to fetch form: ", error);
      });
}

const getSession = (url, sessionKey, callback) => {
  const client = getGraphQLClient(url + '/Importer', {});
  client
    .query({
      query: gql`
        query($sessionKey: String) { getSession (sessionKey: $sessionKey) { sessionKey, user_id, formData, files, totalSize, label, filesUploaded { name, path, complete, totalSize, receivedSize, totalBytes, receivedBytes} }}`, variables: { 'sessionKey': sessionKey }
    })
    .then(function (result) {
      // console.log('getSession result: ', result.data);
      callback(result.data['getSession']);
    }).catch(function (error) {
      console.log("Error while attempting to get session ", error);
    });
}

const updateSession = (url, sessKey, formData, callback) => {
  const client = getGraphQLClient(url + '/Importer', {});
  let stringFormData = JSON.stringify(formData);
  // console.log('stringFormData: ', stringFormData);
  client
    .query({
      query: gql`
        query($sessionKey: String, $formData: String) { updateSession (sessionKey: $sessionKey, formData: $formData) { updated, validationErrors }}`, variables: { 'sessionKey': sessKey, 'formData': stringFormData }
    })
    .then(function (result) {
      callback(result.data['updateSession']);
    }).catch(function (error) {
      console.log("Error while attempting to update form ", error);
    });
}

const submitSession = (url, sessKey, formData, callback) => {
  const client = getGraphQLClient(url + '/Importer', {});
  let stringFormData = JSON.stringify(formData);
  // console.log('stringFormData: ', stringFormData);
  client
    .query({
      query: gql`
        query($sessionKey: String, $formData: String) { submitSession (sessionKey: $sessionKey, formData: $formData) { updated, validationErrors }}`, variables: { 'sessionKey': sessKey, 'formData': stringFormData }
    })
    .then(function (result) {
      callback(result.data['updateSession']);
    }).catch(function (error) {
      console.log("Error while attempting to submit form ", error);
    });
}

export { getGraphQLClient, getSessionList, deleteImport, getNewSession, getFormList, getForm, getSession, updateSession, submitSession } ;
