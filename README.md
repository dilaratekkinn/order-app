
## App Hakkında

Bu kaynak bir case üzerine oluşturulmuş olup,profesyonel kaynaklarda kullanmadan önce lütfen kontrol edin.

Siparişler için, ekleme / silme / listeleme işlemlerinin gerçekleştirildiği ve eerilen siparişler için indirimleri hesaplayan bir RESTful API servisi bulunur.

Docker ile projeyi kaldırmak için : ./vendor/bin/sail up  


- - **Yeni sipariş eklenirken, satın alınan ürünün stoğu yeterli değilse (products.stock) bir hata mesajı döndürür.
- - **Requestlerde gerekli validasyonlar gerçekleşir.
- - **Toplam 1000TL ve üzerinde alışveriş yapan bir müşteri, siparişin tamamından %10 indirim kazanır.
- - **2 ID'li kategoriye ait bir üründen 6 adet satın alındığında, bir tanesi ücretsiz olarak verilir.
- - **1 ID'li kategoriden iki veya daha fazla ürün satın alındığında, en ucuz ürüne %20 indirim yapılır.

## Kullanılan Önemli Kütüphaneler

- - **Laravel Passport.
  Passport keyler için : php artisan passport:install
