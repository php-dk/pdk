[![wercker status](https://app.wercker.com/status/f0d86138ad4234bf0dcf42597bebc088/s/master "wercker status")](https://app.wercker.com/project/byKey/f0d86138ad4234bf0dcf42597bebc088)

# PHP Development Kit

more information [in wiki](https://github.com/php-dk/pdk/wiki)

## Lang (pdk\lang\*)

### Integer (pdk\lang\TInt)
 
 ```php
       $int = new TInt(1);
       $int->getValue(); // return int 1 
       TInt::instanceof(1); //true
       TInt::instanceof(new TInt(1)); //true
       TInt::instanceof('1'); //false
       
       //compare
       $int = new TInt(5);
       static::assertTrue($int->equals(5));
       static::assertTrue($int->less(6));
       static::assertTrue($int->lessEquals(5));
       static::assertTrue($int->more(4));
       static::assertTrue($int->moreEquals(5));
       static::assertTrue($int->equals(new TInt(5)));
       static::assertTrue($int->less(new TInt(6)));
       static::assertTrue($int->lessEquals(new TInt(5)));
       static::assertTrue($int->more(new TInt(4)));
       static::assertTrue($int->moreEquals(new TInt(5)));
       static::assertFalse($int->equals('5'));
       static::assertFalse($int->equals(new TString('5')));
```
### TString

```php
       $string = new TString("hello world");
       [$hello, $world]  = $string->split(' ');
```

### TArray
```php
       $array = (new TArray(['1', '2', '3']))->map(function() {
             //foreach
       });

       $array = (new TArray(['1', '2', '3']))->filter(function() {
             //foreach
       });
```
# Utils

## Collection (pdk\util\*)
### TList
```php
      $collection = new TList(A::class);
      $collection = TList::new(A::class, [...]);
```        

      
