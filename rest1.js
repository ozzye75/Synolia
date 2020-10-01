// Créer un token qui sera utilisé plus tard
var settings = {
  "url": "https://sg-exotest.demo.sugarcrm.eu/rest/v11/oauth2/token",
  "method": "POST",
  "timeout": 0,
  "headers": {
    "Content-Type": "application/json"
  },
  "data": {
    "grant_type": "password",
    "client_id": "melissa",
    "client_secret": "passwordM$*",
    "username": "melissa",
    "password": "3s%oHgbXEShC8ViX"
  }
};

$.ajax(settings).done(function (response) {
  console.log(response);
});

// Dans ces bout de code, il aurait fallu passer le token en relatif plutôt qu'en dur
//récupèrer des contacts avec un filtre sur le first_name commençant par a ( quand j'ai ajouté or filter[0][last_name][$contains]=B ça ne fonctionnait plus)
var settings = {
    "url": "https://sg-exotest.demo.sugarcrm.eu/rest/v11/Contacts/?fields=first_name,last_name,primary_address_street,primary_address_city,primary_address_state,primary_address_postcode,primary_address_country,email_adress&filter[0][first_name][$starts]=A",
    "method": "GET",
    "timeout": 0,
    "headers": {
        "": "",
        "Authorization": "Bearer 9f95321a-7d55-4c04-964a-92cacdb9a2de"
    },
};

$.ajax(settings).done(function (response) {
    console.log(response);
});

$.ajax(settings).done(function (response) {
    console.log(response);
});


// Récupèrer les données d'un contact en particulier
var settings = {
    "url": "https://sg-exotest.demo.sugarcrm.eu/rest/v11/Contacts/91ba3dac-01ae-11eb-bcea-023123a8c872",
    "method": "GET",
    "timeout": 0,
    "headers": {
        "": "",
        "Authorization": "Bearer c6237882-88d2-475b-badf-c6c838646e02"
    },
};

$.ajax(settings).done(function (response) {
    console.log(response);
});


// Si on ne connait pas l'ID du contact mais que son nom, on peut passer les choses comme ça
var settings = {
    "url": "https://sg-exotest.demo.sugarcrm.eu/rest/v11/Contacts?fields=name,date_entered&filter[1][first_name]=Alexander&filter[0][last_name]=Sims",
    "method": "GET",
    "timeout": 0,
    "headers": {
        "": "",
        "Authorization": "Bearer 2bbb465a-b341-4870-a9ad-2c13aba5f29f"
    },
};

$.ajax(settings).done(function (response) {
    console.log(response);
});


// Récupèrer les tâches du premier enregistrement

var settings = {
    "url": "https://sg-exotest.demo.sugarcrm.eu/rest/v11/Tasks/?fields=status&name&contact_name&contact_id&filter[0][contact_id]=91ba3dac-01ae-11eb-bcea-023123a8c872",
    "method": "GET",
    "timeout": 0,
    "headers": {
        "Authorization": "Bearer aec78dae-fd49-4482-9bd0-42cb15d01a68"
    },
};

$.ajax(settings).done(function (response) {
    console.log(response);
});

// Création d'une tâche à Alexander Sims
var settings = {
    "url": "https://sg-exotest.demo.sugarcrm.eu/rest/v11/Tasks/?name=MyTest&date_entered=2020-09-28T17:15:51+00:00&date_modified=2020-09-28T17:15:51+00:00&modified_user_id=de343b44-032d-11eb-b2b6-023123a8c872&created_by=de343b44-032d-11eb-b2b6-023123a8c872&status=In Progress&contact_id=91ba3dac-01ae-11eb-bcea-023123a8c872&contact_name=Alexander Sims",
    "method": "POST",
    "timeout": 0,
    "headers": {
        "": "",
        "Authorization": "Bearer 1408ec5c-06fd-439b-8178-d4c354b17f76"
    },
};

$.ajax(settings).done(function (response) {
    console.log(response);
});

