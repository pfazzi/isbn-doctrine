# isbn-doctrine

The pfazzi/isbn-doctrine package provides the ability to use pfazzi/isbn as a Doctrine field type.

## Installation

The preferred method of installation is via [Packagist][] and [Composer][]. Run
the following command to install the package and add it as a requirement to
your project's `composer.json`:

```bash
composer require pfazzi/isbn-doctrine
```

## Examples

### Configuration

To configure Doctrine to use pfazzi/isbn as a field type, you'll need to set up
the following in your bootstrap:

``` php
\Doctrine\DBAL\Types\Type::addType('isbn', 'Pfazzi\Isbn\Doctrine\IsbnType');
```
In Symfony:
 ``` yaml
# app/config/config.yml
doctrine:
    dbal:
        types:
            isbn: Pfazzi\Isbn\Doctrine\IsbnType
 ```
 
Then, in your models, you may annotate properties by setting the `@Column`
type to `isbn`. Doctrine will handle the rest.

``` php
/**
 * @ORM\Entity()
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="isbn")
     *
     * @var Isbn
     */
    private $isbn;
    
    public function __construct(Isbn $isbn)
    {
        $this->isbn = $isbn;
    }

    public function getIsbn(): Isbn
    {
        return $this->isbn;
    }
}
```

[packagist]: https://packagist.org/packages/ramsey/uuid-doctrine
[composer]: http://getcomposer.org/