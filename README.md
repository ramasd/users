**Show Users Full Names**
----
  Accepts an array with users first names and last names and returns json data with a users full names.</br>
  For the request to work, the HTTP `X-API-Key` request header equal to `"secret"` must be added.

* **URL**

  /api/users

* **Method:**

  `POST`
  
* **URL Params**

  None
  
* **Data Params**

  `users[*][first_name]=[string]` (required with `users[*][last_name]`)<br />
  `users[*][last_name]=[string]` (required with `users[*][first_name]`)
  
* **Success Response:**

  * **Code:** 200 OK<br />
    **Content:**
    ```json
    {
        "users": [
            {
                "full_name": "Tom Tucker"
            },
            {
                "full_name": "Tom, Tucker"
            }
        ]
    }
    ```
    
* **Error Response:**

  * **Code:** 422 UNPROCESSABLE ENTITY <br />
    **Content:** 
    ```json
    {
        "message": "The given data was invalid.",
        "errors": {
            "users.0.first_name": [
                "The users.0.first_name field is required when users.0.last_name is present."
            ]
        }
    }
    ```
    
  OR

  * **Code:** 401 UNAUTHORIZED <br />
    **Content:** `{ "message": "Invalid API Key!" }`
