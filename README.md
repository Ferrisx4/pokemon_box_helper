# Pokemon Box Helper
Designed to help you organize Pokemon into boxes within Bank or Home.

Currently supports National Dex # order, no offsets for alternate forms.

# Usage
Example - Call by number
```shell
$ php pokebank_helper.php 71
Pokemon number 71, Victreebel, goes in box: (61 - 90), column 5, row 2
```

Example - call by name:
```shell
$ php pokebank_helper.php Victreebel
Pokemon number 71, Victreebel, goes in box: (61 - 90), column 5, row 2
```

You can also request multiple Pokémon at a time, with mixed numbers and names:
```shell
$ php pokebank_helper.php Chansey 25 Ekans
Pokemon number 113, Chansey, goes in box: (91 - 120), column 5, row 4
Pokemon number 25, Pikachu, goes in box: (1 - 30), column 1, row 5
Pokemon number 23, Ekans, goes in box: (1 - 30), column 5, row 4
```

