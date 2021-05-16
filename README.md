----------------------
# Setup Local Development

----------------------
We will use DDEV for setting up a local development environment.
1. Download DDEV
2. Follow the steps to setup DDEV: https://ddev.readthedocs.io/en/stable/
3. Open Command Line and go to the folder of the project (e.g. /projects/ruleengine)
4. Start DDEV - ``` ddev start ```
5. Go into the container - ``` ddev ssh ```
6. Install the needed packages - ``` composer install ```
7. Create the needed tables in mysql - ``` ./flow doctrine:migrate ```

If you followed these steps, you should be able to access the site via http://ruleengine.ddev.site.

----------------------
# Setup Production Environment

----------------------
For setting up a webserver, please contact your administrator. The following content are here to help.

### Install packages
* Don't forget to install the needed packages first: ``` composer install ```

### Database connection
* Rename the file in ``` /Configuration/Production/Settings.yaml.example ``` to ``` /Configuration/Production/Settings.yaml ```
* Set your credentials to your database in this file
* If this does not work, try copying the content to ``` /Configuration/Settings.yaml ```

### Creating tables
* Flow allows you to create all the necessary tables using one single command
* Using the command line go to the folder where the project is based
* Call this command: ``` ./flow doctrine:migrate ``` (if this does not work try setting the context: ``` FLOW_CONTEXT=Production ./flow doctrine:migrate ```)

----------------------
# Rule-Engine API

----------------------

## Apply rules

Returns the data after applying the rules.

To use this function the following path needs to be called:

> /api/apply

### Example Request

Pass the following body as POST request:

```
{
    "data": 
    [
        {
            "id": 1,
            "class": "node",
            "type": "A"
        },
        {
            "id": 2,
            "class": "node",
            "type": "B"
        },
        {
            "id": 3,
            "class": "node",
            "type": "B"
        },
        {
            "id": 4,
            "class": "edge",
            "type": "B"
        }
    ],
    "rules": 
    [
        {
            "modify": [
                {"var":""},
                "type",
                "B"
            ]
        }
    ],
    "maxRecursive": 10,
    "runRecursive": false
}
```

### Parameters for `apply`
`data`
> * (Required, Array) Data that the rules are applied to

`rules`
> * (Required, Array) Rules to be applied

`maxRecursive`
> * (Optional, Integer) Limit of max recursive executions

`runRecursive`
> * (Optional, Boolean) If `false`, then the rules will be applied once only, default is set to `true`

-------

## Add rules

Adds a ruleset to the database, returns response if successful.

To use this function the following path needs to be called:

> /api/add

### Example Request

Pass the following body as POST request:
```
{
    "name": "My API Rule"
    "description": "This is my description"
    "rules": 
    [
        {
            "modify": [
                {"var":""},
                "type",
                "B"
            ]
        }
    ]
}
```

### Parameters for `add`
`name`
> * (Required, String) Name of the ruleset

`description`
> * (Required, String) Description of the ruleset

`rules`
> * (Required, Array) Rules of the ruleset