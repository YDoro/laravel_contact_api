# Contacts API

## Introduction

> This is a contact list API created with laravel 6. And it will be used as a test for my development skills;

## Installation

> Clone this project and then do a `composer install `
> After `composer install ` peform a `php artisan key:generate`
> And then `php artisan passport:client --personal`
> Name the personal access client of `contacts_api`
## Insomnia REST Client File
>You can import the `contacts_api_endpoints.json` located on the root of the project into your insomnia REST client to import all API endpoints bellow at once
## API ENDPOINTS
> ### User
> #### Register
>>Method: Post \
>>Endpoint: /api/register  \
>>Body:
>>>{\
>>>"name":"Your name",\
>>>"email":"Your@email.com",\
>>>"password":"your_password",\
>>>"c_password":"your_password_again"\
>>>}
> #### Login
>>Method: Post \
>>Endpoint: /api/login  \
>>Body Data :
>>>{\
>>>"email":"Your@email.com",\
>>>"password":"your_password",\
>>>}
> #### Details
>>Method: Post \
>>Endpoint: /api/details  \
>>Headers:
>>>Accept : application/json,\
>>>Authorization :Bearer $your_access_Token,\
>>


> ### Contacts
> #### Create
>>Method: Post \
>>Endpoint: /api/contacts  \
>>Headers:
>>>Accept : application/json,\
>>>Authorization :Bearer $your_access_Token,\
>>Body:
>>>{\
>>>"name":"Contact name",\
>>>"email":"Contact@email.com",\
>>>"CEP":"Contact CEP",\
>>>"phone":"contact phone"\
>>>"address":"contact address"\
>>>}
> #### List
>>Method: GET \
>>Endpoint: /api/contacts  \
>>Headers:
>>>Accept : application/json,\
>>>Authorization :Bearer $your_access_Token,\
> #### Update
>>Method: Put \
>>Endpoint: /api/contacts  \
>>Headers:
>>>Accept : application/json,\
>>>Authorization :Bearer $your_access_Token,\
>>Body:
>>>{\
>>>"name":"Contact name",\
>>>"email":"Contact@email.com",\
>>>"CEP":"Contact CEP",\
>>>"phone":"contact phone"\
>>>"address":"contact address"\
>>>}
> #### Delete
>>Method: DELETE \
>>Endpoint: /api/contacts/$contact_id  \
>>Headers:
>>>Accept : application/json,\
>>>Authorization :Bearer $your_access_Token,\
> #### Show
>>Method: GET \
>>Endpoint: /api/contacts/$contact_id  \
>>Headers:
>>>Accept : application/json,\
>>>Authorization :Bearer $your_access_Token,\
