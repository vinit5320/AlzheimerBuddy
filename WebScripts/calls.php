curl -X POST -k -H "Content-Type: application/json" -H "Authorization: Bearer ae96553a8f294f088e44ae094ddb95c0" "https://api.api.ai/v1/userEntities?v=20150910&sessionId=53201" -d @entities.json

curl -X GET -H "Content-Type: application/json" -H "Authorization: Bearer 0cbaaaa24a674f149471d8f4ac9c459d" "https://api.api.ai/v1/userEntities/@things?v=20150910&sessionId=53201"

curl -k -H "Authorization: Bearer 0cbaaaa24a674f149471d8f4ac9c459d" "https://api.api.ai/v1/entities"

curl -k -H "Authorization: Bearer ae96553a8f294f088e44ae094ddb95c0" "https://api.api.ai/v1/entities/d075c23c-7ad4-4e61-8e87-314adf94c956?v=20150910"


PUT Entity
curl -i -X POST -H "Content-Type:application/json" -H "Authorization:Bearer ae96553a8f294f088e44ae094ddb95c0" -d '[{"value": "bottle","synonyms": ["water bottle"]}]' 'https://api.api.ai/v1/entities/things/entries?v=20150910'

PUT Intent
curl -k -X PUT -H "Content-Type: application/json; charset=utf-8" -H "Authorization: Bearer ae96553a8f294f088e44ae094ddb95c0" --data "{'name':'change appliance state 1','auto':true,'contexts':[],'templates':['turn @state:state the @appliance:appliance ','switch the @appliance:appliance @state:state '],'userSays':[{'data':[{'text':'let '},{'text':'on','alias':'state','meta':'@state'},{'text':' the '},{'text':'bug report','alias':'report','meta':'@report'}],'isTemplate':false,'count':0},{'data':[{'text':'switch the '},{'text':'heating','alias':'appliance','meta':'@appliance'},{'text':' '},{'text':'off','alias':'state','meta':'@state'}],'isTemplate':false,'count':0}],'responses':[{'resetContexts':false,'action':'set-appliance','affectedContexts':[{'name':'house','lifespan':10}],'parameters':[{'dataType':'@appliance','name':'appliance','value':'\$appliance'},{'dataType':'@state','name':'state','value':'\$state'}],'speech':'Turning the \$appliance \$state\!'}],'priority':500000}" "https://api.api.ai/v1/intents/finding-object-context?v=20150910"

CREATE Intent
curl -k -H "Content-Type: application/json; charset=utf-8" -H "Authorization: Bearer ae96553a8f294f088e44ae094ddb95c0" --data "{'name':'change appliance state 1','auto':true,'contexts':[],'templates':['turn @state:state the @appliance:appliance ','switch the @appliance:appliance @state:state '],'userSays':[{'data':[{'text':'let '},{'text':'on','alias':'state','meta':'@state'},{'text':' the '},{'text':'bug report','alias':'report','meta':'@report'}],'isTemplate':false,'count':0},{'data':[{'text':'fuck the '},{'text':'heating','alias':'appliance','meta':'@appliance'},{'text':' '},{'text':'off','alias':'state','meta':'@state'}],'isTemplate':false,'count':0}],'responses':[{'resetContexts':false,'action':'set-appliance','affectedContexts':[{'name':'house','lifespan':10}],'parameters':[{'dataType':'@appliance','name':'appliance','value':'\$appliance'},{'dataType':'@state','name':'state','value':'\$state'}],'speech':'Turning the \$appliance \$state\!'}],'priority':500000}" "https://api.api.ai/v1/intents/e5a49e52-9e22-4ec7-9f9e-b4789a770867?v=20150910"

curl -k -X PUT -H "Content-Type: application/json; charset=utf-8" -H "Authorization: Bearer ae96553a8f294f088e44ae094ddb95c0" --data "{'name':'set appliance on or off','auto':true,'contexts':[],'templates':['turn @state:state the @appliance:appliance ','switch the @appliance:appliance @state:state '],'userSays':[{'data':[{'text':'swik '},{'text':'on','alias':'state','meta':'@state'},{'text':' the '},{'text':'kitchen lights','alias':'appliance','meta':'@appliance'}],'isTemplate':false,'count':0},{'data':[{'text':'fuck the '},{'text':'heating','alias':'appliance','meta':'@appliance'},{'text':' '},{'text':'off','alias':'state','meta':'@state'}],'isTemplate':false,'count':0}],'responses':[{'resetContexts':false,'action':'set-appliance','affectedContexts':[{'name':'house','lifespan':10}],'parameters':[{'dataType':'@appliance','name':'appliance','value':'\$appliance'},{'dataType':'@state','name':'state','value':'\$state'}],'speech':'Turning the \$appliance \$state\!'}],'priority':500000}" "https://api.api.ai/v1/intents/e5a49e52-9e22-4ec7-9f9e-b4789a770867?v=20150910"