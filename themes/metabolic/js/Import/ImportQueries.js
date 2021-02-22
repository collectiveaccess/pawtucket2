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

const getSessionList = (url, callback) => {
  const client = getGraphQLClient('http://metabolic3.whirl-i-gig.com:8085' + url + '/Importer', {});
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

const deleteImport = (url, sessKey, callback) => {
  const client = getGraphQLClient('http://metabolic3.whirl-i-gig.com:8085' + url + '/Importer', {});
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

const getNewSession = (url, callback) => {
  const client = getGraphQLClient('http://metabolic3.whirl-i-gig.com:8085' + url + '/Importer', {});
  //TODO: Do not hardcode form, add a variable that gets passed to function
  client
    .query({
      query: gql`
        query { newSession (form: "crisisarchive"){ sessionKey }}`
    })
    .then(function (result) {
      // console.log('newSession result: ', result.data.newSession.sessionKey);
      callback(result.data['newSession']);
    }).catch(function (error) {
      console.log("Error while attempting to create newSession: ", error);
    });
}

const getFormList = (url, callback) => {
  const client = getGraphQLClient('http://metabolic3.whirl-i-gig.com:8085' + url + '/Importer', {});
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
  const client = getGraphQLClient('http://metabolic3.whirl-i-gig.com:8085' + url + '/Importer', {});
  
    client
      .query({
        query: gql` query ($code: String!) { form (code: $code) { title, type, description, properties, required } } `, variables: { 'code': formCode }
      })
      .then(function (result) {
        // console.log('form result: ', result.data.form);
        callback(result.data['form']);
      }).catch(function (error) {
        console.log("Error while attempting to fetch form: ", error);
      });
}

const getSession = (url, sessionKey, callback) => {
  const client = getGraphQLClient('http://metabolic3.whirl-i-gig.com:8085' + url + '/Importer', {});
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
  const client = getGraphQLClient('http://metabolic3.whirl-i-gig.com:8085' + url + '/Importer', {});
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
  const client = getGraphQLClient('http://metabolic3.whirl-i-gig.com:8085' + url + '/Importer', {});
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
