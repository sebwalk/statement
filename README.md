# statement
A **PHP library** to **read, parse and match** bank account exports.

You can use statement to

- Parse CSV bank statements into usable PHP classes
- Guess column mappings
- Match domain objects with transaction descriptions (e.g. for payment processing)

## Installation
```
composer require sebastianwalker/statement
```

## Transactions
```php
// Transaction ($amount, $description, $payer, $iban, $date)
$transaction = new \SebastianWalker\Statement\Transaction(12.34, "Desc", "John Doe", "DE...00", new \Carbon\Carbon("2018-02-12"));

$transaction->getAmount(); // float

$transaction->getDescription(); // string

$transaction->getPayer(); // string

$transaction->getIban(); // string | null

$transaction->getDate(); // Carbon instance: http://carbon.nesbot.com/docs/
```

## Importing statements
### From CSV

```php
// FromCsv($filename, $delimiter, $known_mapping, $known_offset)
$importer = new \SebastianWalker\Statement\Importers\FromCsv("file.csv");

// Get the imported transactions
$transactions = $importer->getTransactions();

// Get the mapping used (guessed + known_mapping)
$mapping = $importer->getMapping();
/*[
  "amount"=>"Amount",
  "description"=>"Description",
  "payer"=>"Payer/Payee",
  "iban"=>"IBAN",
  "date"=>"Valuta Date"
]*/

// Get the column titles usable for mapping as an array
$columns = $importer->getColumns();
```

### From Array
```php
// FromArray($transactions)
$importer = new \SebastianWalker\Statement\Importers\FromArray([/*Array of Transactions*/]);

// Get the imported transactions
$transactions = $importer->getTransactions();
```

## Matching Transactions with Domain Objects

### Matching by Prefix
Ask your payers to include a transaction description of {Your Prefix}{Your Object Identifier} when sending the funds.  
_Example Description: PFIX-12345678_

```php
$matcher = new \SebastianWalker\Statement\Matchers\PrefixMatcher("PFIX-");

// Get all matching entities that are referenced in a given transaction
$matches = $matcher->getEntities($transaction);
```

The prefix matcher looks for occurrences in the transaction's description of the given prefix and returns the appended part of each of them.

### Matching by Entity List
Ask your payers to include an object identifier (e.g. their record's id) in the transaction description when sending the funds.
_Example Description: 12345678_

```php
// Pass basic strings
$matcher = new \SebastianWalker\Statement\Matchers\ListMatcher(["1234","5678","9012"]);

// OR set a property which will be matched
$matcher = new \SebastianWalker\Statement\Matchers\ListMatcher([
    ["id"=>"1234"],
    ["id"=>"5678"],
    ["id"=>"9012"]
], "id");

// Get all matching entities that are referenced in a given transaction
$matches = $matcher->getEntities($transaction);
```

The list matcher looks for occurences in the transaction's description of the items contained in the given list and returns all matching items.

