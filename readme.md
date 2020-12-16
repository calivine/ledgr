# Ledgr
*Alex Caloggero*

## Version 2.0.0

*Monthly Budget And Expense Tracking*

# API Documentation

### Base Url:
`https://ledgr.site/api`

## Endpoints

### Budget
This is an object representing a monthly budget - a category name, planned amount, and actual amount.
```
GET  /budget/categories/:name/:filter
GET  /budget/categories/:filter
GET  /budget/categories
POST /budget/categories
```

#### Attributes
**name** string

Name of the budget category.

**filter** string

Parameter to filter the list by. Can be one of:

    - planned
    - actual
    - category

### Activity
Activity is an object that represents individual transactions.
```
GET  /activity/transactions/:start/:stop
GET  /activity/transactions
POST /activity/transactions
```

#### Attributes
**start** string

The starting date for range of transactions to retrieve. Should be in the format: YYYY-MM-DD.

**stop** string

The ending date for range of transactions to retrieve. Should be in the format: YYYY-MM-DD.
