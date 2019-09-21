#Playfinder Tech Test

###API
GET /pitches - complete with functional tests

GET /pitches/1 - complete with functional tests 

GET /pitches/1/slots - complete with functional tests 

POST /pitches/1/slots - incomplete

###Notes

I would have liked to cover the jsonapi classes with 
unit tests. However, due to the time spent attempting to 
fix the last method, I have not yet written unit tests. I 
have covered all endpoints with functional tests.

In the DataFixturesTestCase class, I had an issue with the
getApplication singleton. It worked for the first test and 
then failed for subsequent tests. So I just return a new 
application each time.

Regarding the final method that I haven't completed, I 
reserve engineered an example of an API build with the JSONAPI 
bundle (paknahad/jsonapi-bundle), but found an issue that 
appears to be in the Hydrator class, that creates new slots.
With limited documentation and only a reverse engineered 
example for reference, I have stepped through the code to 
isolate the issue, but am still unclear regarding the cause / fix.