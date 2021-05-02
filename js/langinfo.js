// Swati Srivastava (ss3ck)

function showLanguage(lang) {
   if (lang.length == 0) return;

   // 2. Create an instance of an XMLHttpRequest object
   xhr = GetXmlHttpObject();
   if (xhr == null)
   {
      alert ("Your browser does not support XMLHTTP!");
      return;
   }


   // 3. specify a backend handler (URL to the backend)
   var url = "langinfoDB.php";

   // 4. Assume we are going to send a GET request,
   //    use url rewriting to pass information the backend needs to process the request
   url = url + "?selectedLang=" + lang;

   // 5. Configure the XMLHttpRequest instance.
   //    Register the callback function.
   //    Assume the callback function is named showHint(),
   //    don't forget to write code for the callback function at the bottom
   xhr.onreadystatechange = serverResponse;

   // 8. Once the response is back the from the backend,
   //    the callback function is called to update the screen
   //    (this will be handled by the configuration above)

   // 6. Make an asynchronous request
   xhr.open("GET", url, true);    // true means asynch (default)

   // 7. The request is sent to the server
   xhr.send(null);  // avoid old firefox version complaining
}

function serverResponse() {
   if(xhr.readyState == 4 && xhr.status == 200) {
      if(xhr.responseText != null) {
         var splitResponse = xhr.responseText.split("\n");
         document.getElementById("selected-lang").textContent = "Facts about " + splitResponse[0];
         document.getElementById("fact1").textContent = splitResponse[1];
         document.getElementById("fact2").textContent = splitResponse[2];
         document.getElementById("fact3").textContent = splitResponse[3];
         document.getElementById("fact4").textContent = splitResponse[4];
      }
  }
}


function GetXmlHttpObject()
{
  // Create an XMLHttpRequest object
  
  if (window.XMLHttpRequest)
  {  // code for IE7+, Firefox, Chrome, Opera, Safari
     return new XMLHttpRequest();
  }
  if (window.ActiveXObject)
  { // code for IE6, IE5
    return new ActiveXObject ("Microsoft.XMLHTTP");
  }
  return null;
}


