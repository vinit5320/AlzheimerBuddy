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
                    putDBResponse(query, itemName, context, "select", ""+event.request.intent.name);
                    break;

                case "FindingObjectContext":
                    respondBack('What is it that you are looking for ?', false, {
                        "context": "FindingObjectContext"
                    }, context);
                    break;

                case "SaveThingsContext":
                    var itemName = event.request.intent.slots.thingsslot.value;
                    respondBack('Where exactly are you keeping your ' + itemName, false, {
                        "itemName": itemName,
                        "context": "SaveThingsContext"
                    }, context);
                    break;

                case "OthersMemory":
                    var userName = "vinit";
                    if(event.request.intent.slots.personName.hasOwnProperty('value')){
                        userName = ""+event.request.intent.slots.personName.value;
                    }
                    userName = (userName === "me") ? "vinit" : userName;
                    var query = (userName === "random") ? "SELECT memory FROM memories ORDER BY RAND() LIMIT 1" :
                        "SELECT memory from memories where person = '" + userName + "'";
                    putDBResponse(query, userName, context, "select", ""+event.request.intent.name);
                    break;

                case "FamilySearch":
                    if(event.request.intent.slots.personName.hasOwnProperty('value')){
                        var personName = ""+event.request.intent.slots.personName.value;
                        var query = "SELECT * from family where name = '" + personName + "'";
                        
                        getDBResponse(query, function(err, response) {
                            if(response !== null)
                            respondBack(response[0].name+' is your '+response[0].relationship+' who '+response[0].description, true, {}, context);
                            else
                            {
                                respondBack("Sorry, no such person found.", true, {}, context);
                            }
                        });
                        
                        break;

                    } else if(event.request.intent.slots.personRelation.hasOwnProperty('value')){
                        var personRelation = ""+event.request.intent.slots.personRelation.value;
                        var query = "SELECT * from family where relationship = '" + personRelation + "'";
                        
                        console.log(event.session.user.userId);
                        
                        getDBResponse(query, function(err, response) {
                            if(response !== null){
                                if(response.length > 1)
                                {
                                    var res = "You have "+response.length+" "+personRelation+".";
                                
                                    for(i in response)
                                    {
                                       res += ' '+response[i].name+' is your '+response[i].relationship+' who '+response[i].description+' .';        
                                    }
                                    
                                    respondBack(res, true, {}, context);
                                }
                                else
                                {
                                    respondBack(" "+response[0].name+" is your "+response[0].relationship+" who "+response[0].description+" .", true, {}, context);
                                }
                            }
                            else 
                            {
                                respondBack("Sorry, no such relation found.", true, {}, context);
                            }
                        });
                    }
                    break;

                default:
                    errorResponse(context);
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

    if(currentContext === "FindThings"){
        itemName = event.request.intent.slots.thingsslot.value;
    } else if(currentContext === "SaveThingsLocation") {
        itemName = event.session.attributes.itemName;
        params = event.request.intent.slots.thingsLocation.value;
    } else if(currentContext === "DecisionBool") {
        itemName = event.session.attributes.itemName;
        params = event.request.intent.slots.yesNoBool.value;
    }

    switch(true) {

        case currentContext === "FindThings":
            query = "SELECT location FROM things WHERE name = '" + itemName + "'";
            putDBResponse(query, itemName, context, "select",currentContext);
            break;

        case currentContext === "SaveThingsLocation" && prevContext === "SaveThingsContext":
            params = params.replace(/my/g, 'your');
            params = params.replace(/mine/g, 'yours');

            if(event.request.intent.slots.yesNoBool.hasOwnProperty('value') &&
                (event.request.intent.slots.yesNoBool.value === "no")) {}
            else {

                getDBResponse("SELECT * FROM things WHERE name = '"+itemName+"'", function(err, response) {
                    if(response !== null){
                        query = "UPDATE things SET location= '"+params+"' WHERE name = '"+itemName+"'";
                        putDBResponse(query, itemName, context,"insert", currentContext);
                    }
                    else {
                        query = "INSERT INTO things (name, location) VALUES ( '"+itemName+"', '"+params+"')";
                        putDBResponse(query, itemName, context,"insert", currentContext);
                    }
                });
            }
             break;

        case currentContext === "DecisionBool" && prevContext === "SaveThingsContext":
            if(params === "yes") {
                respondBack('Where exactly are you keeping your ' + itemName, false, {
                    "itemName": itemName,
                    "context": "SaveThingsContext"
                }, context);
            } else {
                respondBack("Okay, what else can I help you with ?", true,{},context);
            }
            break;

        default:
            errorResponse(context);
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

errorResponse = (context) => {
    respondBack("I don't know what you meant by that Can you please try again?", true, {}, context);
}

//DB Connection
putDBResponse = (query, itemName, context, type, intentContext) => {

    if(type === "insert") {
        connection.query(query, function(err, rows) {
            if (err) throw err;
            if(intentContext && intentContext === "SaveThingsLocation") {
                connection.end();
                respondBack("Okay I will remember that location.", true, {}, context);
            } else {
                connection.end();
                respondBack("I don't know what you meant by that Can you please try again?", true, {}, context);
            }
        });


    } else if(type === "select") {
        connection.query(query, function (err, rows) {
            if (err) throw err;

            if(intentContext && (intentContext === "FindThings" || intentContext === "FindingObjectContext")) {
                if (rows[0] !== undefined) {
                    
                    var loc = rows[0].location;
                    connection.end();
                    respondBack(loc, true, {}, context);
                } else {
                    connection.end();
                    respondBack("Sorry I don't have it in my memory. Do you want me to remember the location of "+itemName+" ?", false, {
                        "itemName": itemName,
                        "context": "SaveThingsContext"
                    }, context);
                }

            } else if(intentContext && intentContext === "OthersMemory") {
                if (rows[0] !== undefined) {
                    var mem = rows[0].memory;
                    connection.end();
                    respondBack(mem, true, {}, context);
                } else {
                    connection.end();
                    respondBack("Sorry I don't have any memories right now.", false, {}, context);
                }
            } else {
                connection.end();
                respondBack("I don't know what you meant by that Can you please try again?", true, {}, context);
            }
        });
    }
}

// getDBResponse = (query) => {
//
//     connection.query(query, function (err, rows) {
//         if (err) throw err;
//             if (rows[0] !== undefined) {
//                 console.log("DATA AYAAA");
//                 console.log(rows);
//                 return rows[0];
//             } else {
//                 return '';
//             }
//     });
//
// }


function getDBResponse(query, callback) {

    connection.query(query, function (err, rows) {
        if (err) throw err;
        if (rows[0] !== undefined) {
            callback(null, rows);
        } else {
            callback(null, null);
        }
    });
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
