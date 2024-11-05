# Guest app

The guest has the following fields: ID, name, last name, email, phone, country. Name, last name and phone are required fields. Phone and email are unique. If the country is not specified, then get the country from the phone number.

## Launch
`docker compose up`

or 

`make up`

## API
## Get list of guests
### Request
`GET /guest`

    curl -X GET -i http://localhost:81/guest

### Response
    HTTP/1.1 200 OK
    Server: nginx/1.27.1
    Content-Type: application/json
    Transfer-Encoding: chunked
    Connection: keep-alive
    X-Powered-By: PHP/8.2.25
    X-Debug-Time: 2.124
    X-Debug-Memory: 866.1015625
    Cache-Control: no-cache, private
    Date: Tue, 05 Nov 2024 10:32:06 GMT
    X-Robots-Tag: noindex

    {"guests":[{"id":10,"firstName":"foo","lastName":"bar","phone":"+70000000000","email":"foo@example.com","country":"Russia"}]}

## Create new guest
### Request
`POST /guest`

    `curl -X POST -i http://localhost:81/guest -H "Content-Type: application/x-www-form-urlencoded" -d "firstName=foo&lastName=bar&phone=%2bXXXXXXXXXXX&country=name&email=example@example.com"`

### Response
    HTTP/1.1 201 Created
    Server: nginx/1.27.1
    Content-Type: application/json
    Transfer-Encoding: chunked
    Connection: keep-alive
    X-Powered-By: PHP/8.2.25
    X-Debug-Time: 16.153
    X-Debug-Memory: 996.59375
    Cache-Control: no-cache, private
    Date: Tue, 05 Nov 2024 10:48:11 GMT
    X-Robots-Tag: noindex
    
    []

## Create new guest - bad request
### Request
`POST /guest`

    curl -X POST -i http://localhost:81/guest -H "Content-Type: application/x-www-form-urlencoded" -d ""

### Response
    HTTP/1.1 400 Bad Request
    Server: nginx/1.27.1
    Content-Type: application/json
    Transfer-Encoding: chunked
    Connection: keep-alive
    X-Powered-By: PHP/8.2.25
    X-Debug-Time: 11.677
    X-Debug-Memory: 1000.9140625
    Cache-Control: no-cache, private
    Date: Tue, 05 Nov 2024 10:54:01 GMT
    X-Robots-Tag: noindex
    
    {"errors":[{"property":"firstName","value":null,"message":"This value should not be blank."},{"property":"lastName","value":null,"message":"This value should not be blank."},{"property":"phone","value":null,"message":"This value should not be blank."}]}

## Get a specific guest
### Request
`GET /guest/id`

    curl -X GET -i http://localhost:81/guest/10

### Response
    HTTP/1.1 200 OK
    Server: nginx/1.27.1
    Content-Type: application/json
    Transfer-Encoding: chunked
    Connection: keep-alive
    X-Powered-By: PHP/8.2.25
    X-Debug-Time: 0.122
    X-Debug-Memory: 846.5390625
    Cache-Control: no-cache, private
    Date: Tue, 05 Nov 2024 10:57:50 GMT
    X-Robots-Tag: noindex
    
    {"guest":{"id":10,"firstName":"foo","lastName":"bar","phone":"+70000000001","email":"foo@example.com","country":"Russia"}}

## Get a non-existent guest
### Request
`GET /guest/id`

    curl -X GET -i http://localhost:81/guest/1235

### Response
    HTTP/1.1 404 Not Found
    Server: nginx/1.27.1
    Content-Type: application/json
    Transfer-Encoding: chunked
    Connection: keep-alive
    X-Powered-By: PHP/8.2.25
    X-Debug-Time: 0.064
    X-Debug-Memory: 833.4609375
    Cache-Control: no-cache, private
    Date: Tue, 05 Nov 2024 11:01:19 GMT
    X-Robots-Tag: noindex
    
    []

## Change a guest
### Request
`PUT /guest/id`

    `curl -X PUT -i http://localhost:81/guest/10 -H "Content-Type: application/x-www-form-urlencoded" -d "firstName=foo&lastName=bar&phone=%2bXXXXXXXXXXX&country=name&email=example@example.com"`

### Response
    HTTP/1.1 200 OK
    Server: nginx/1.27.1
    Content-Type: application/json
    Transfer-Encoding: chunked
    Connection: keep-alive
    X-Powered-By: PHP/8.2.25
    X-Debug-Time: 12.612
    X-Debug-Memory: 1004.359375
    Cache-Control: no-cache, private
    Date: Tue, 05 Nov 2024 11:38:29 GMT
    X-Robots-Tag: noindex
    
    []

## Change a guest - bad request
### Request
`PUT /guest/id`

    curl -X PUT -i http://localhost:81/guest/10 -H "Content-Type: application/x-www-form-urlencoded" -d ""

### Response
    HTTP/1.1 400 Bad Request
    Server: nginx/1.27.1
    Content-Type: application/json
    Transfer-Encoding: chunked
    Connection: keep-alive
    X-Powered-By: PHP/8.2.25
    X-Debug-Time: 4.245
    X-Debug-Memory: 989.9140625
    Cache-Control: no-cache, private
    Date: Tue, 05 Nov 2024 11:50:59 GMT
    X-Robots-Tag: noindex
    
    {"errors":[{"property":"firstName","value":null,"message":"This value should not be blank."},{"property":"lastName","value":null,"message":"This value should not be blank."},{"property":"phone","value":null,"message":"This value should not be blank."}]}


## Delete a specific guest
### Request
`DELETE /guest/id`

    curl -X DELETE -i http://localhost:81/guest/10

### Response
    HTTP/1.1 200 OK
    Server: nginx/1.27.1
    Content-Type: application/json
    Transfer-Encoding: chunked
    Connection: keep-alive
    X-Powered-By: PHP/8.2.25
    X-Debug-Time: 3.134
    X-Debug-Memory: 1202.9921875
    Cache-Control: no-cache, private
    Date: Tue, 05 Nov 2024 11:52:54 GMT
    X-Robots-Tag: noindex
    
    []

## Delete a non-existent guest
### Request
`DELETE /guest/id`

    curl -X DELETE -i http://localhost:81/guest/1235

### Response
    HTTP/1.1 404 Not Found
    Server: nginx/1.27.1
    Content-Type: application/json
    Transfer-Encoding: chunked
    Connection: keep-alive
    X-Powered-By: PHP/8.2.25
    X-Debug-Time: 0.072
    X-Debug-Memory: 5732.671875
    Cache-Control: no-cache, private
    Date: Tue, 05 Nov 2024 11:54:13 GMT
    X-Robots-Tag: noindex
    
    []