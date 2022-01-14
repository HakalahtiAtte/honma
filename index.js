/**
 * Haetaan tavitut elementit domista
 */
 var form = document.querySelector("form");
 var loginResult = document.querySelector("p")
 
 /**
  * Lisätään napeille kuuntelijafunktiot
  */
 
 form.addEventListener("submit", login)
 
 /**
  * @param {Event} e
  */
 function login(e){
     e.preventDefault();
 
     //Muunnetaan form-data olioksi
     var data = new FormData(form)
 
     //base64 koodataan käyttäjän antamat käyttäjätunnus:salasana
     var base64cred = btoa( data.get("username")+":"+data.get("password") )
 
     //Luodaan basic auth otsikko ja muut parametrit
     //Authorization: Basic xxxxxxxxx
     var params = {
         headers: { 'Authorization':'Basic ' + base64cred },
         withCredentials: true,
         method: 'post'
     }
 
 
     fetch('http://localhost/honma/login.php', params)
         .then(resp => resp.text())
         .then( data => loginResult.textContent = data)            
         .catch(e => {
             loginResult.textContent = "Epäonnistui!!!!"
         })
         
 }
 