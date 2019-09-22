#Playfinder Tech Test

###API
GET /pitches - complete with functional tests

GET /pitches/1 - complete with functional tests 

GET /pitches/1/slots - complete with functional tests 

POST /pitches/1/slots - complete with functional tests

{
	"data": 
		{
			"type" : "slots",
	    	"attributes" : {
	        	"starts" : "2019-09-21 14:00:00",
	            "ends" : "2019-09-21 15:00:00",
	            "price" : "20",
	            "currency"  :"GBP",
	            "available" : "true"
	        }
	    }
}

###Notes

With a bit more time, I would have liked to increase test coverage.
For now, the core logic is covered with unit tests and  all 
endpoints are covered with functional tests.

I found an issue with the getApplication method in the 
DataFixtureTestCase, where the singleton failed after the first test.
As a workaround, I return a new application with each call to 
getApplication. This is not ideal as it slows down execution of the 
test suite.

The POST method returns a 200 on success instead of a 201 as per the spec.


