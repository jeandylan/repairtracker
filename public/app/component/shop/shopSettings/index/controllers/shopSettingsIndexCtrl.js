/**
 * Created by dylan on 13-Aug-16.
 */
app.controller("shopSettingsIndexCtrl",function ($scope) {
   console.log('d');
   var CLIENT_ID = '<YOUR_CLIENT_ID>';

   var SCOPES = ['https://www.googleapis.com/auth/gmail.readonly'];

   /**
    * Check if current user has authorized this application.
    */
   function checkAuth() {
      gapi.auth.authorize(
          {
             'client_id': CLIENT_ID,
             'scope': SCOPES.join(' '),
             'immediate': true
          }, handleAuthResult);
   }

   /**
    * Handle response from authorization server.
    *
    * @param {Object} authResult Authorization result.
    */
   function handleAuthResult(authResult) {
      var authorizeDiv = document.getElementById('authorize-div');
      if (authResult && !authResult.error) {
         // Hide auth UI, then load client library.
         authorizeDiv.style.display = 'none';
         loadGmailApi();
      } else {
         // Show auth UI, allowing the user to initiate authorization by
         // clicking authorize button.
         authorizeDiv.style.display = 'inline';
      }
   }

   /**
    * Initiate auth flow in response to user clicking authorize button.
    *
    * @param {Event} event Button click event.
    */
   function handleAuthClick(event) {
      gapi.auth.authorize(
          {client_id: CLIENT_ID, scope: SCOPES, immediate: false},
          handleAuthResult);
      return false;
   }

   /**
    * Load Gmail API client library. List labels once client library
    * is loaded.
    */
   function loadGmailApi() {
      gapi.client.load('gmail', 'v1', listLabels);
   }

   /**
    * Print all Labels in the authorized user's inbox. If no labels
    * are found an appropriate message is printed.
    */
   function listLabels() {
      var request = gapi.client.gmail.users.labels.list({
         'userId': 'me'
      });

      request.execute(function(resp) {
         var labels = resp.labels;
         appendPre('Labels:');

         if (labels && labels.length > 0) {
            for (i = 0; i < labels.length; i++) {
               var label = labels[i];
               appendPre(label.name)
            }
         } else {
            appendPre('No Labels found.');
         }
      });
   }

});