//create a request variable then assign new XMLHttpRequest object to it
var request = new XMLHttpRequest()

//Open new connection, using the GET request on the URL endpoint
request.open('GET', 'http://dnd5eapi.co/api/races/', true)

request.onload = function () {

}

request.send()