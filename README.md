[![wercker status](https://app.wercker.com/status/f0d86138ad4234bf0dcf42597bebc088/s/master "wercker status")](https://app.wercker.com/project/byKey/f0d86138ad4234bf0dcf42597bebc088)

PHP Development Kit

- Описание типов данных через ООП
TArray, TString

 - тестовове описание для проверки обновления через композер
0.3.9

Example:
 - collection

        $collection = new TCollection(A::class);
        $collection = new TCollection(A::class, [...]);
        $collection = TCollection::new(A::class, [...]);

 - array

       $array = new TArray(['1', '2', '3'])->map(function() {
             //foreach
       });

       $array = new TArray(['1', '2', '3'])->foreach(function() {
             //foreach
       });

       $array = new TArray(['1', '2', '3'])->filter(function() {
             //foreach
       });
