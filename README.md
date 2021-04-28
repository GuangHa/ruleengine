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