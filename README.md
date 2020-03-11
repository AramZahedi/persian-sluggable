# تولید خودکار اسلاگ (نامک) برای لاراول 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/AramZahedi/persian-sluggable.svg?style=flat-square)](https://packagist.org/packages/aram-zahedi/persian-sluggable)

This package is a localized version of [Spatie\Sluggable](https://github.com/spatie/laravel-sluggable) with Persian language support.


## معرفی پکیج

<div dir="rtl">
با استفاده از این پکیج میتوانید برای مدل های خود در لاراول به صورت خودکار اسلاگ (نامک) تولید کنید.
</div>
<br>
<div dir="rtl">
<b>ورژن های پشتیبانی شده لاراول:</b>
5.8 و 6 و 7
</div>
<br>
<p dir="rtl">به مثال زیر توجه کنید:</p>

```php
$model = new EloquentModel();
$model->name = 'سلام دنیا';
$model->save();

echo $model->slug; // "سلام-دنیا"
```
<div dir="rtl">


نامک توسط کلاس Slug داخل پکیج تولید میشود که تمام فاصله داخل متن مشخص شده را به خط تیره `-` تبدیل میکند.


</div>

## نصب پکیج

<div dir="rtl">
    با استفاده از Composer دستور زير را وارد کنيد تا پکيج نصب شود.
</div>
<br>

``` bash
composer require aram-zahedi/persian-sluggable
```

## طریقه استفاده
<div dir="rtl">


مدل های شما باید از Trait پکیج به اسم `AramZahedi\Sluggable\HasSlug` استفاده کند و تابع زیر را با توجه به نیاز خود در مدل تعریف کرده باشد.
مایگریشن شما نیز باید یک ستون مخصوص برای ذخیره نامک یا Slug داشته باشد.
به عنوان مثال:


</div>
<br>

```php
<?php

namespace App;

use AramZahedi\Sluggable\HasSlug;
use AramZahedi\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class YourEloquentModel extends Model
{
    use HasSlug;
    
    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name') // فیلدی که نام از رویش تولید میشود
            ->saveSlugsTo('slug'); // فیلدی که نامک در آن ذخیره میشود
    }
}
```

<br>

<div dir="rtl">همچنین در داخل فایل مایگریشن:</div>

<br>

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYourEloquentModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('your_eloquent_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug'); // اسم ستونی که نامک در آن ذخیره میشود
            $table->string('name');
            $table->timestamps();
        });
    }
}

```

<br>

<div dir="rtl">همچنین میتوانید کلید اصلی مدل را برای روتر به شکل زیر به نام تغییر دهید.</div>

<br>


```php
namespace App;

use AramZahedi\Sluggable\HasSlug;
use AramZahedi\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class YourEloquentModel extends Model
{
    use HasSlug;
    
    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
    
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug'; // کلید جدید برای router
    }
}
```

<br>

<div dir="rtl">میخواهید نام از ترکیب دو ستون مختلف تولید شود؟ پس به این شکل عمل کنید.</div>

<br>

```php
public function getSlugOptions() : SlugOptions
{
    return SlugOptions::create()
        ->generateSlugsFrom(['first_name', 'last_name']) //تولید نامک از ترکیب دو ستون نام و نام خانوادگی
        ->saveSlugsTo('slug');
}
```

<br>

<div dir="rtl">به طور پیش فرض نام های تولید شده، یکتا بوده و امکان وجود نامک تکراری وجود ندارد. در صورتی که بخواهید اجازه وجود نامک های تکراری را بدهید، باید به متد getSlugOptions خط زیر را اضافه کنید:</div>

`->allowDuplicateSlugs()`

<br>

<div dir="rtl">به این شکل:</div>

<br>

```php
public function getSlugOptions() : SlugOptions
{
    return SlugOptions::create()
        ->generateSlugsFrom('name')
        ->saveSlugsTo('slug')
        ->allowDuplicateSlugs();
}
```

<br>

<div dir="rtl">همچنین میتوانید حداکثر طول هر نامک را با فراخوانی تابع زیر تعیین کنید:</div>

` ->slugsShouldBeNoLongerThan() `

<br>

<div dir="rtl">به این شکل:</div>

<br>

```php
public function getSlugOptions() : SlugOptions
{
    return SlugOptions::create()
        ->generateSlugsFrom('name')
        ->saveSlugsTo('slug')
        ->slugsShouldBeNoLongerThan(50);
}
```

<br>

<div dir="rtl">البته فراموش نکنید به علت چسبیدن یک پشوند عددی به آخر بعضی نامک ها (به علت ایجاد یکتایی) ممکن است طول نامک کمی بیشتر از مقدار تعیین شده باشد.</div>

<br>

<div dir="rtl">همچنین میتوانید با فراخوانی تابع زیر، جداکننده مد نظر خود را به جای خط تیره، استفاده کنید:</div>

` ->usingSeparator(".") `

<br>

<div dir="rtl">به این شکل:</div>

<br>

```php
public function getSlugOptions() : SlugOptions
{
    return SlugOptions::create()
        ->generateSlugsFrom('name')
        ->saveSlugsTo('slug')
        ->usingSeparator('.');
}
```

<br>

<div dir="rtl">به محض ایجاد مدل، نامک به صورت خودکار تولید میشود و میتوان دستی نامک را تغییر داد:</div>

<br>

```php
$model = EloquentModel:create(['name' => 'hello world']); // نامک hello-world 
$model->slug = 'my-custom-url';
$model->save(); //نامک جدید "my-custom-url"; 
```

<br>

<div dir="rtl">در صورتی که مایل باشید موقع ایجاد مدل جدید، نامک 
<b>به صورت خودکار تولید نشود</b>
میتوانید تابع زیر را فرخوانی کنید:</div>

` ->doNotGenerateSlugsOnCreate() `

<br>

<div dir="rtl">به اين شکل:</div>

<br>

```php
public function getSlugOptions() : SlugOptions
{
    return SlugOptions::create()
        ->generateSlugsFrom('name')
        ->saveSlugsTo('slug')
        ->doNotGenerateSlugsOnCreate();
}
```

<br>

<div dir="rtl">هر موقع مقدار name را (که تعیین کردید نامک از روی آن تولید شود) تغییر دهید، پس از ذخیره مدل، نامک نیز به طور خودکار از روی مقدار جدید مجدداً تولید میشود:</div>
<div dir="rtl">در صورتی که میخواهید پس از تغییر مقدار ستون انتخابی نا، نامک مجدداً
<b>به صورت خودکار تولید نشود</b>
تابع زیر را فراخوانی کنید:</div>


` ->doNotGenerateSlugsOnUpdate() `

<br>

<div dir="rtl">به اين شکل:</div>

<br>

```php
public function getSlugOptions() : SlugOptions
{
    return SlugOptions::create()
        ->generateSlugsFrom('name')
        ->saveSlugsTo('slug')
        ->doNotGenerateSlugsOnUpdate();
}
```

<br>

<div dir="rtl">
<b>این کار برای زمانی ضروری است که بخواهید از روی نامک، لینک صفحات سایت را تولید کنید که به علت اعتبار در گوگل و... نباید مقدارشان عوض شود.</b>
</div>

<br>

```php
$model = EloquentModel:create(['name' => 'my name']); //نامک "my-name"; 
$model->save();

$model->name = 'new name';
$model->save(); //نامک مثل قبل "my-name"
```

<br>

<div dir="rtl">هرگاه خواستید نامک مجدداً از روی ستون انتخابی ما تولید شود، میتوانید به صورت دستی تابع زیر را روی مدل خود فراخوانی کنید:</div>

` ->generateSlug() `

<br>

<div dir="rtl">در این صورت
<b>فراموش نکنید که حتماً با فراخوانی تابع save مدل خود را ذخیره نمایید.</b>
</div>

<br>

```php
$model = EloquentModel:create(['name' => 'my name']); //نامک "my-name"; 
$model->save();

$model->name = 'new name';
$model->save(); //نامک مثل قبل "my-name"

$model->generateSlug();
$model->save();//نامک اکنون "new-name"
```

<br>

## تست پکیج

``` bash
composer test
```

<br>

## امنیت

<div dir="rtl">در صورت بروز هر گونه مشکل میتوانید از طریق آدرس ایمیل زیر، با ما در ارتباط باشید:</div>

`aram1376@yahoo.com`