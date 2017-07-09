[![wercker status](https://app.wercker.com/status/f0d86138ad4234bf0dcf42597bebc088/s/master "wercker status")](https://app.wercker.com/project/byKey/f0d86138ad4234bf0dcf42597bebc088)

PHP Development Kit

Example:
 - lang 
 ```php
       $int = new TInt(1);
       $int->getValue(); // return int 1 
       TInt::instanceof(1); //true
       TInt::instanceof(new TInt(1)); //true
       TInt::instanceof('1'); //false
   
 - collection

        $collection = new TList(A::class);
        $collection = TList::new(A::class, [...]);
        

 - array

       $array = (new TArray(['1', '2', '3']))->map(function() {
             //foreach
       });

       $array = (new TArray(['1', '2', '3']))->filter(function() {
             //foreach
       });
