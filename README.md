# Bank app!

[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/arashrasoulzadeh/ss-test/laravel.yml?branch=master&label=tests&style=flat-square)](https://github.com/arashrasoulzadeh/ss-test/actions?query=workflow%3Alaravel+branch%3Amaster)

### test

to test application, you need to first run `php artisan migrate --seed` and then you may use following routes:

```
to transfer from a card to another:
POST http://localhost:8000/api/transfer
with following data:
{
    "source":"6274-1290-0547-3742",
    "destination":"6104337465312385",
    "amount":10
}

to get top3 users in last 10 minutes with latest 10 transactions:
GET http://localhost:8000/api/report

```

or you may run test using :

```
php artisan test
```

you may set notification channel with `NOTIFICATION_CHANNEL=kavenegar` in you env, you may also use `NOTIFICATION_CHANNEL=ghasedak`
