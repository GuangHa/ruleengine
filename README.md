
# Setup Local Development

We will use DDEV for setting up a local development environment.
1. Download DDEV
2. Follow the steps to setup DDEV: https://ddev.readthedocs.io/en/stable/
3. Open Command Line and go to the folder of the project (e.g. /projects/ruleengine)
4. Start DDEV - ``` ddev start ```
5. Go into the container - ``` ddev ssh ```
6. Install the needed packages - ``` composer install ```
7. Create the needed tables in mysql - ``` ./flow doctrine:migrate ```

If you followed these steps, you should be able to access the site via http://ruleengine.ddev.site.

# Setup Production Environment

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

# Rule-Engine API

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


# New JSON Logic functions and modifications

There are new added functions to JSON Logic and there are also some modifications to existing functions.

## Cartesian
Create a cartesian product out of two sources.

### Data
``` 
[
	{"id": 1},
	{"id": 2}
]
 ```

### Rule
``` 
{
	"cartesian": [
		{"var":""},
		{"var":""}
	]
}
```

### Output
``` 
[
    [
        {"id": 1},
        {"id": 1}
    ],
    [
        {"id": 1},
        {"id": 2}
    ],
    [
        {"id": 2},
        {"id": 1}
    ],
    [
        {"id": 2},
        {"id": 2}
    ]
]
```

## Modify
Modify existing or create a new attribute.\
Parameter 1: data to modify\
Parameter 2: attribute key\
Parameter 3: attribute value

### Data
```
[
	{
		"id": 1,
		"class": "node",
		"type": "A"
	}
]
```

### Rule
```
{
	"modify": [
		{"var":""}, 
		"type", 
		"B"
	]
}
```

### Output
```
[
    {
        "id": 1,
        "class": "node",
        "type": "B"
    }
]
```

## Remove
Remove an attribute.\
Parameter 1: data\
Parameter 2: attribute key

### Data
```
[
	{
		"id": 1,
		"class": "node",
		"type": "A"
	}
]
```

### Rule
```
{
	"remove": [
		{"var":""}, 
		"type"
	]
}
```

### Output
```
[
    {
        "id": 1,
        "class": "node"
    }
]
```

## Group
Groups given data using given name.\
Parameter 1: data\
Parameter 2: name

### Data
```
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
    }
]
```

### Rule
```
{
    "group": [
        {"var":""},
        "mygroupname"
    ]
}
```

### Output
```
{
    "mygroupname": [
        {
            "id": 1,
            "class": "node",
            "type": "A"
        },
        {
            "id": 2,
            "class": "node",
            "type": "B"
        }
    ]
}
```

## Join
Joins two sources together.\
Parameter 1: data\
Parameter 2: data

### Data
```
[
    {
        "id": 1,
        "class": "node",
        "type": "A"
    }
]
```

### Rule
```
{
    "join": [
        {"var":""},
        {"var":""}
    ]
}
```

### Output
```
[
    {
        "id": 1,
        "class": "node",
        "type": "A"
    },
    {
        "id": 1,
        "class": "node",
        "type": "A"
    }
]
```

## Sqrt
Square root of the given number.\
Parameter 1: number
Parameter 2: rounding precision after coma

### Data
```
2
```

### Rule
```
[
    {
        "sqrt": [{"var":""}, 2]
    }
]
```

### Output
```
1.41
```

## Create
Create a new object. Infinite parameters can be given, where first parameter is the data.

### Data
```
[
    {
        "id": 1,
        "class": "node",
        "type": "A"
    }
]
```

### Rule
```
[
    {
        "create":[
            {"var":""},
            ["attribute1", "value 1"],
            ["attribute2", "value 2"]
        ]
    }
]
```

### Output
```
[
    {
        "id": 1,
        "class": "node",
        "type": "A"
    },
    {
        "attribute1": "value 1",
        "attribute2": "value 2"
    }
]
```

## Delete
Delete objects from the data.\
Parameter 1: data\
Parameter 2: key to filter
Parameter 3: value to filter

### Data
```
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
    }
]
```

### Rule
```
[
    {
        "delete":[
            {"var":""},
            "type",
            "A"
        ]
    }
]
```

### Output
```
[
    {
        "id": 1,
        "class": "node",
        "type": "A"
    }
]
```

## Count
Count the objects of the given data.

### Data
```
[
    {
        "id": 1
    },
    {
        "id": 2
    }
]
```

### Rule
```
[
    {
        "count":[
            {"var":""}
        ]
    }
]
```

### Output
```
2
```

## Slice
Slice the given array.\
Parameter 1: array\
Parameter 2: offset\
Parameter 3: length

### Data
```
[
    {
        "id": 1
    },
    {
        "id": 2
    }
]
```

### Rule
```
[
    {
        "slice":[
            {"var":""}, 
            1, 
            1
        ]
    }
]
```

### Output
```
[
    {
        "id": 2
    }
]
```

## Var
The var-function is modified to be able to use the original given datasource or a given source in the 4th parameter.

### Use original data source
```
[
    {
        "var":[
            "", 
            null, 
            true
        ]
    }
]
```

### Use given data source
If the 4th parameter is set, the 3rd parameter will be ignored.
```
[
    {
        "var":[
            "", 
            null, 
            true,
            {"var":"myNewDataSource"}
        ]
    }
]
```