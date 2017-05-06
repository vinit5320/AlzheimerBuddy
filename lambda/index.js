var https = require('https')
var mysql = require('mysql')

var connection;

exports.handler = (event, context) => {

    try {

        connection = mysql.createConnection({
            host     : 'mysqlforlambdatest.cxjr41nyvqjk.us-east-1.rds.amazonaws.com',
            user     : 'keval',
            ssl : 'Amazon RDS',
            password : 'mypassword',
            database : 'ExampleDB',
            port : '3306',
        });

        if (event.session.new) {
            newSessionHelper(event, context);
        } else {
            oldSessionHelper(event, context);
        }


    } catch(error) { context.fail('Exception: '+error) }

}

newSessionHelper = (event,context) => {
    switch (event.request.type) {

        case "LaunchRequest":
            // Launch Request
            respondBack("You can ask for finding things, sharing memories, family information, etc.", true, {}, context);
            break;

        case "IntentRequest":
            // Intent Request

            switch(event.request.intent.name) {

                case "FindThings":
                    var itemName = event.request.intent.slots.thingsslot.value;
                    var query = "SELECT location from things where name = '" + itemName + "'";
                    getDBResponse(query, itemName, context, "select", ""+event.request.intent.name);
                    break;

                case "FindingObjectContext":
                    respondBack('What is it that you are looking for ?', false, {
                        "context": "FindingObjectContext"
                    }, context);
                    break;

                case "SaveThingsContext":
                    var itemName = event.request.intent.slots.thingsLocation.value;
                    respondBack('Where are you exactly keeping your ' + itemName, false, {
                        "itemName": itemName,
                        "context": "SaveThingsContext"
                    }, context);
                    break;

                case "OthersMemory":
                    var userName = "vinit";
                    if(event.request.intent.slots.personName.hasOwnProperty('value')){
                        userName = ""+event.request.intent.slots.personName.value;
                    }
                    var query = "SELECT memory from memories where person = '" + userName + "'";
                    getDBResponse(query, userName, context, "select", ""+event.request.intent.name);
                    break;

                default:
                    respondBack("Sorry I cannot handle your request right now.", true,{},context);
                    break;

            }
            break;

        case "SessionEndedRequest":
            // Session Ended Request
            break;

        default:
            context.fail('INVALID REQUEST TYPE: '+event.request.type)

    }
}

oldSessionHelper = (event,context) => {

    var itemName,params,currentContext,query,prevContext;

    prevContext = event.session.attributes.context;
    currentContext = event.request.intent.name;

    if(currentContext === "FindingObjectContext"){
        itemName = event.request.intent.slots.thingsslot.value;
    } else if(currentContext === "SaveThingsLocation") {
        itemName = event.session.attributes.itemName;
        params = event.request.intent.slots.thingsLocation.value;
    } else if(currentContext === "DecisionBool") {
        itemName = event.session.attributes.itemName;
        params = event.request.intent.slots.yesNoBool.value;
    }

    switch(true) {

        case currentContext === "FindingObjectContext":
            query = "SELECT location FROM things WHERE name = '" + itemName + "'";
            getDBResponse(query, itemName, context, "select",currentContext);
            break;

        case currentContext === "SaveThingsLocation" && prevContext === "SaveThingsContext":
            params = params.replace(/my/g, 'your');
            params = params.replace(/mine/g, 'yours');
            query = "INSERT INTO things (name, location) VALUES ( '"+itemName+"', '"+params+"')";
            getDBResponse(query, itemName, context,"insert", currentContext);
            break;

        case currentContext === "DecisionBool" && prevContext === "SaveThingsContext":
            if(params === "yes") {
                respondBack('Where are you exactly keeping your ' + itemName, false, {
                    "itemName": itemName,
                    "context": "SaveThingsContext"
                }, context);
            } else {
                respondBack("Okay, what else can I help you with ?", true,{},context);
            }
            break;

        default:
            respondBack("Sorry I cannot handle your request right now.", true,{},context);
            break;

    }
}

//Reponse
respondBack = (response, endSession, attributes, context) => {
    context.succeed(
        generateResponse(
            buildSpeechletResponse(response, endSession),
            attributes
        )
    )
}

//DB Connection
getDBResponse = (query, itemName, context, type, intentContext) => {

    if(type === "insert") {
        connection.query(query, function(err, rows) {
            if (err) throw err;
            if(intentContext && intentContext === "SaveThingsLocation") {
                respondBack("Okay I will remember that location permanently", true, {}, context);
            } else {
                respondBack("Sorry I cannot handle your request right now.", true, {}, context);
            }
        });


    } else if(type === "select") {
        connection.query(query, function (err, rows) {
            if (err) throw err;

            if(intentContext && (intentContext === "FindThings" || intentContext === "FindingObjectContext")) {
                if (rows[0] !== undefined) {
                    var loc = rows[0].location;
                    respondBack(loc, true, {}, context);
                } else {
                    respondBack("Sorry I don't have it in my memory. Do you want me to remember the location of "+itemName+" ?", false, {
                        "itemName": itemName,
                        "context": "SaveThingsContext"
                    }, context);
                }

            } else if(intentContext && intentContext === "OthersMemory") {
                if (rows[0] !== undefined) {
                    var mem = rows[0].memory;
                    respondBack(mem, true, {}, context);
                } else {
                    respondBack("Sorry I don't have any memories right now.", false, {}, context);
                }

            } else {
                respondBack("Sorry I cannot handle your request right now.", true, {}, context);
            }
        });
    }
}


// Speechlet Helpers
buildSpeechletResponse = (outputText, shouldEndSession) => {

    return {
        outputSpeech: {
            type: "PlainText",
            text: outputText
        },
        shouldEndSession: shouldEndSession
    }

}

generateResponse = (speechletResponse, sessionAttributes) => {

    return {
        version: "1.0",
        sessionAttributes: sessionAttributes,
        response: speechletResponse
    }

}
